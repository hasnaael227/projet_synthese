import React, { useEffect, useState } from "react";
import axios from "axios";
import { useNavigate, useParams } from "react-router-dom";
import Swal from "sweetalert2";
import {
  Alert,
  Button,
  Card,
  Form,
  Container,
  Row,
  Col,
  Spinner,
} from "react-bootstrap";
import { useForm, Controller } from "react-hook-form";
import ReactQuill from "react-quill";
import "react-quill/dist/quill.snow.css";

const EditCours = () => {
  const { id } = useParams();
  const navigate = useNavigate();

  // React Hook Form pour le champ 'contenu'
  const {
    control,
    setValue,
    handleSubmit: handleSubmitRHF,
    formState: { errors },
  } = useForm({
    defaultValues: {
      contenu: "",
    },
  });

  // useState pour les autres champs
  const [cours, setCours] = useState({
    titre: "",
    category_id: "",
    chapitre_id: "",
    image: null,
    type_pdf: null,
    type_video: null,
  });

  const [categories, setCategories] = useState([]);
  const [chapitres, setChapitres] = useState([]);
  const [loading, setLoading] = useState(true);
  const [submitting, setSubmitting] = useState(false);
  const [errorsBackend, setErrors] = useState({});

  // Charger cours, catégories et chapitres au montage
  useEffect(() => {
    const fetchData = async () => {
      try {
        const [coursRes, categoriesRes, chapitresRes] = await Promise.all([
          axios.get(`http://localhost:8000/api/cours/${id}`),
          axios.get("http://localhost:8000/api/categories"),
          axios.get("http://localhost:8000/api/chapitres"),
        ]);

        const data = coursRes.data;

        setCours({
          titre: data.titre || "",
          category_id: data.category_id || "",
          chapitre_id: data.chapitre_id || "",
          image: null,
          type_pdf: null,
          type_video: null,
        });

        // Set contenu dans RHF
        setValue("contenu", data.contenu || "");

        setCategories(categoriesRes.data || []);
        setChapitres(chapitresRes.data || []);
      } catch (error) {
        Swal.fire("Erreur", "Impossible de charger les données", "error");
      } finally {
        setLoading(false);
      }
    };
    fetchData();
  }, [id, setValue]);

  // Gestion des autres champs
  const handleChange = (e) => {
    const { name, value } = e.target;
    setCours((prev) => ({ ...prev, [name]: value }));
  };

  // Gestion des fichiers
  const handleFileChange = (e) => {
    const { name, files } = e.target;
    setCours((prev) => ({ ...prev, [name]: files[0] }));
  };

  // Soumission du formulaire
  const onSubmit = async (dataForm) => {
    setSubmitting(true);
    setErrors({});

    const formData = new FormData();
    formData.append("titre", cours.titre);
    formData.append("contenu", dataForm.contenu);
    formData.append("category_id", cours.category_id);
    formData.append("chapitre_id", cours.chapitre_id);

    if (cours.image instanceof File) formData.append("image", cours.image);
    if (cours.type_pdf instanceof File) formData.append("type_pdf", cours.type_pdf);
    if (cours.type_video instanceof File) formData.append("type_video", cours.type_video);

    try {
      await axios.post(`http://localhost:8000/api/cours/${id}?_method=PUT`, formData, {
        headers: { "Content-Type": "multipart/form-data" },
      });
      Swal.fire("Succès", "Cours modifié avec succès", "success");
      navigate("/Formateur/ListeCours");
    } catch (error) {
      if (error.response?.data?.errors) {
        setErrors(error.response.data.errors);
      }
      Swal.fire("Erreur", "La modification a échoué", "error");
    } finally {
      setSubmitting(false);
    }
  };

  if (loading)
    return (
      <Container className="mt-5 text-center">
        <Spinner animation="border" role="status" />
        <p>Chargement...</p>
      </Container>
    );

  return (
    <Container className="mt-5">
      <Row className="justify-content-center">
        <Col md={8}>
          <Card className="shadow-sm rounded-3">
            <Card.Header className="bg-primary text-white text-center">
              <h4>Modifier un Cours</h4>
            </Card.Header>
            <Card.Body>
              {/* Affichage erreurs générales */}
              {Object.keys(errorsBackend).length > 0 && (
                <Alert variant="danger">
                  Veuillez corriger les erreurs dans le formulaire.
                </Alert>
              )}

              <Form onSubmit={handleSubmitRHF(onSubmit)} encType="multipart/form-data">
                <Form.Group className="mb-3" controlId="titre">
                  <Form.Label>Titre</Form.Label>
                  <Form.Control
                    type="text"
                    name="titre"
                    value={cours.titre}
                    onChange={handleChange}
                    isInvalid={!!errorsBackend.titre}
                    required
                  />
                  <Form.Control.Feedback type="invalid">
                    {errorsBackend.titre}
                  </Form.Control.Feedback>
                </Form.Group>

                <Form.Group className="mb-3">
                  <Form.Label>Contenu</Form.Label>
                  <Controller
                    name="contenu"
                    control={control}
                    rules={{ required: "Le contenu est requis" }}
                    render={({ field }) => (
                      <ReactQuill
                        {...field}
                        onChange={field.onChange}
                        className={errors.contenu ? "is-invalid" : ""}
                      />
                    )}
                  />
                  {errors.contenu && (
                    <div className="invalid-feedback d-block">{errors.contenu.message}</div>
                  )}
                </Form.Group>

                <Form.Group className="mb-3" controlId="category_id">
                  <Form.Label>Catégorie</Form.Label>
                  <Form.Select
                    name="category_id"
                    value={cours.category_id}
                    onChange={handleChange}
                    isInvalid={!!errorsBackend.category_id}
                    required
                  >
                    <option value="">-- Choisir une catégorie --</option>
                    {categories.map((cat) => (
                      <option key={cat.id} value={cat.id}>
                        {cat.name}
                      </option>
                    ))}
                  </Form.Select>
                  <Form.Control.Feedback type="invalid">
                    {errorsBackend.category_id}
                  </Form.Control.Feedback>
                </Form.Group>

                <Form.Group className="mb-3" controlId="chapitre_id">
                  <Form.Label>Chapitre</Form.Label>
                  <Form.Select
                    name="chapitre_id"
                    value={cours.chapitre_id}
                    onChange={handleChange}
                    isInvalid={!!errorsBackend.chapitre_id}
                    required
                  >
                    <option value="">-- Choisir un chapitre --</option>
                    {chapitres.map((chap) => (
                      <option key={chap.id} value={chap.id}>
                        {chap.titre}
                      </option>
                    ))}
                  </Form.Select>
                  <Form.Control.Feedback type="invalid">
                    {errorsBackend.chapitre_id}
                  </Form.Control.Feedback>
                </Form.Group>

                <Form.Group className="mb-3" controlId="image">
                  <Form.Label>Image (optionnel)</Form.Label>
                  <Form.Control
                    type="file"
                    name="image"
                    onChange={handleFileChange}
                    accept="image/*"
                    isInvalid={!!errorsBackend.image}
                  />
                  <Form.Control.Feedback type="invalid">
                    {errorsBackend.image}
                  </Form.Control.Feedback>
                </Form.Group>

                <Form.Group className="mb-3" controlId="type_pdf">
                  <Form.Label>Fichier PDF (optionnel)</Form.Label>
                  <Form.Control
                    type="file"
                    name="type_pdf"
                    onChange={handleFileChange}
                    accept="application/pdf"
                    isInvalid={!!errorsBackend.type_pdf}
                  />
                  <Form.Control.Feedback type="invalid">
                    {errorsBackend.type_pdf}
                  </Form.Control.Feedback>
                </Form.Group>

                <Form.Group className="mb-3" controlId="type_video">
                  <Form.Label>Vidéo (optionnel)</Form.Label>
                  <Form.Control
                    type="file"
                    name="type_video"
                    onChange={handleFileChange}
                    accept="video/mp4,video/avi,video/mpeg"
                    isInvalid={!!errorsBackend.type_video}
                  />
                  <Form.Control.Feedback type="invalid">
                    {errorsBackend.type_video}
                  </Form.Control.Feedback>
                </Form.Group>

                <Button
                  variant="primary"
                  type="submit"
                  disabled={submitting}
                  className="w-100 rounded-pill"
                >
                  {submitting ? "Modification en cours..." : "Modifier"}
                </Button>
              </Form>
            </Card.Body>
          </Card>
        </Col>
      </Row>
    </Container>
  );
};

export default EditCours;
