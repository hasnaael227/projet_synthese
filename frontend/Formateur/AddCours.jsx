import React, { useState, useEffect } from "react";
import { useForm, Controller } from "react-hook-form";
import { zodResolver } from "@hookform/resolvers/zod";
import * as z from "zod";
import {
  Alert,
  Button,
  Card,
  Form,
  Container,
  Row,
  Col,
} from "react-bootstrap";
import axios from "axios";
import ReactQuill from "react-quill";
import "react-quill/dist/quill.snow.css";
import Swal from "sweetalert2";
import { useNavigate } from "react-router-dom";

// Schéma Zod pour validation
const formSchema = z.object({
  titre: z.string().min(1, { message: "Le titre est requis." }),
  contenu: z.string().min(10, { message: "Le contenu est trop court." }),
  category_id: z.string().min(1, { message: "Catégorie requise." }),
  chapitre_id: z.string().min(1, { message: "Chapitre requis." }),
  image: z.any().optional(),
  type_pdf: z.any().optional(),
  type_video: z.any().optional(),
});

const AddCours = () => {
  const navigate = useNavigate();

  const {
    register,
    handleSubmit,
    formState: { errors, isSubmitting },
    control,
    watch,
    setValue,
  } = useForm({
    resolver: zodResolver(formSchema),
  });

  const [userName, setUserName] = useState("");
  const [userId, setUserId] = useState("");
  const [categories, setCategories] = useState([]);
  const [chapitres, setChapitres] = useState([]);

  // Récupérer utilisateur connecté (ex: formateur)
  useEffect(() => {
    const fetchUser = async () => {
      try {
        const token = localStorage.getItem("token");
        if (!token) return navigate("/admin");

        const response = await axios.get("http://127.0.0.1:8000/api/users", {
          headers: { Authorization: `Bearer ${token}` },
        });

        // Trouver formateur dans la liste des users retournés
        const formateur = response.data.find((u) => u.role === "formateur");
        if (!formateur) {
          Swal.fire("Erreur", "Formateur non trouvé", "error");
          return navigate("/admin");
        }

        setUserName(formateur.name || formateur.prename || formateur.email);
        setUserId(formateur.id);
      } catch (error) {
        console.error("Erreur utilisateur :", error);
        navigate("/admin");
      }
    };

    fetchUser();
  }, [navigate]);

  // Charger catégories
  useEffect(() => {
    axios
      .get("http://127.0.0.1:8000/api/categories")
      .then((res) => setCategories(res.data || []))
      .catch(() => setCategories([]));
  }, []);

  const selectedCategory = watch("category_id");

  // Charger chapitres selon catégorie sélectionnée
  useEffect(() => {
    if (!selectedCategory) {
      setChapitres([]);
      setValue("chapitre_id", "");
      return;
    }

    axios
      .get(`http://127.0.0.1:8000/api/chapitres-by-categorie/${selectedCategory}`)
      .then((res) => setChapitres(res.data || []))
      .catch(() => setChapitres([]));
  }, [selectedCategory, setValue]);

  const onSubmit = async (data) => {
    const token = localStorage.getItem("token");
    if (!token) {
      Swal.fire("Erreur", "Vous devez être connecté.", "error");
      return;
    }

    try {
      const formData = new FormData();
      formData.append("formateur_id", userId); // ID formateur connecté
      formData.append("titre", data.titre);
      formData.append("contenu", data.contenu);
      formData.append("category_id", data.category_id);
      formData.append("chapitre_id", data.chapitre_id);

      if (data.image && data.image[0]) formData.append("image", data.image[0]);
      if (data.type_pdf && data.type_pdf[0]) formData.append("type_pdf", data.type_pdf[0]);
      if (data.type_video && data.type_video[0]) formData.append("type_video", data.type_video[0]);

      await axios.post("http://127.0.0.1:8000/api/cours", formData, {
        headers: {
          Authorization: `Bearer ${token}`,
          "Content-Type": "multipart/form-data",
        },
      });

      Swal.fire("Succès", "Cours ajouté avec succès !", "success");
      navigate("/formateur/cours");
    } catch (error) {
      console.error(error.response?.data);
      Swal.fire(
        "Erreur",
        error.response?.data?.message || "Une erreur est survenue.",
        "error"
      );
    }
  };

  return (
    <Container>
      <Row className="justify-content-center">
        <Col md={8}>
          <Card className="shadow-sm rounded-3">
            <Card.Header className="bg-primary text-white text-center">
              <h4>Ajouter un Cours</h4>
            </Card.Header>
            <Card.Body>
              {Object.keys(errors).length > 0 && (
                <Alert variant="danger">
                  Veuillez corriger les erreurs ci-dessous.
                </Alert>
              )}
              <Form onSubmit={handleSubmit(onSubmit)} encType="multipart/form-data">
                <Form.Group className="mb-3">
                  <Form.Label>Formateur</Form.Label>
                  <Form.Control type="text" value={userName} readOnly />
                </Form.Group>

                <Form.Group className="mb-3">
                  <Form.Label>Titre</Form.Label>
                  <Form.Control
                    type="text"
                    {...register("titre")}
                    isInvalid={!!errors.titre}
                  />
                  <Form.Control.Feedback type="invalid">
                    {errors.titre?.message}
                  </Form.Control.Feedback>
                </Form.Group>

                <Form.Group className="mb-3">
                  <Form.Label>Contenu</Form.Label>
                  <Controller
                    name="contenu"
                    control={control}
                    render={({ field }) => (
                      <ReactQuill
                        {...field}
                        onChange={field.onChange}
                        className={errors.contenu ? "is-invalid" : ""}
                      />
                    )}
                  />
                  {errors.contenu && (
                    <div className="invalid-feedback d-block">
                      {errors.contenu.message}
                    </div>
                  )}
                </Form.Group>

                <Form.Group className="mb-3">
                  <Form.Label>Image</Form.Label>
                  <Form.Control type="file" {...register("image")} />
                </Form.Group>

                <Form.Group className="mb-3">
                  <Form.Label>Fichier PDF</Form.Label>
                  <Form.Control type="file" {...register("type_pdf")} />
                </Form.Group>

                <Form.Group className="mb-3">
                  <Form.Label>Vidéo</Form.Label>
                  <Form.Control type="file" {...register("type_video")} />
                </Form.Group>

                <Form.Group className="mb-3">
                  <Form.Label>Catégorie</Form.Label>
                  <Form.Select {...register("category_id")} isInvalid={!!errors.category_id}>
                    <option value="">Sélectionnez une catégorie</option>
                    {categories.map((cat) => (
                      <option key={cat.id} value={cat.id}>
                        {cat.name}
                      </option>
                    ))}
                  </Form.Select>
                  <Form.Control.Feedback type="invalid">
                    {errors.category_id?.message}
                  </Form.Control.Feedback>
                </Form.Group>

                <Form.Group className="mb-3">
                  <Form.Label>Chapitre</Form.Label>
                  <Form.Select
                    {...register("chapitre_id")}
                    isInvalid={!!errors.chapitre_id}
                    disabled={!selectedCategory}
                  >
                    <option value="">Sélectionnez un chapitre</option>
                    {chapitres.map((chap) => (
                      <option key={chap.id} value={chap.id}>
                        {chap.titre}
                      </option>
                    ))}
                  </Form.Select>
                  <Form.Control.Feedback type="invalid">
                    {errors.chapitre_id?.message}
                  </Form.Control.Feedback>
                </Form.Group>

                <Button
                  type="submit"
                  variant="primary"
                  disabled={isSubmitting}
                  className="w-100 rounded-pill"
                >
                  {isSubmitting ? "Ajout en cours..." : "Ajouter le cours"}
                </Button>
              </Form>
            </Card.Body>
          </Card>
        </Col>
      </Row>
    </Container>
  );
};

export default AddCours;
