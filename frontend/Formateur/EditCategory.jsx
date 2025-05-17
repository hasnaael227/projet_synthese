import React, { useEffect, useState } from "react";
import { useParams, useNavigate } from "react-router-dom";
import { Alert, Button, Card, Form, Container, Row, Col } from "react-bootstrap";
import Swal from "sweetalert2";

const EditCategory = () => {
  const { id } = useParams();
  const navigate = useNavigate();

  const [category, setCategory] = useState({
    name: "",
    description: "",
    prix: "",
    image: "",
  });
  const [image, setImage] = useState(null);
  const [previewImage, setPreviewImage] = useState(null);
  const [errors, setErrors] = useState({});
  const [errorMessage, setErrorMessage] = useState("");
  const [successMessage, setSuccessMessage] = useState("");

  // Charger la catégorie
  useEffect(() => {
    fetch(`http://127.0.0.1:8000/api/categories/${id}`)
      .then((res) => {
        if (!res.ok) throw new Error("Erreur lors du chargement");
        return res.json();
      })
      .then((data) => {
        setCategory(data);
        if (data.image) {
          setPreviewImage(`http://127.0.0.1:8000/storage/${data.image}`);
        }
      })
      .catch((error) => {
        setErrorMessage(error.message || "Erreur de chargement des données");
      });
  }, [id]);

  const handleChange = (e) => {
    setCategory({ ...category, [e.target.name]: e.target.value });
    setErrors({ ...errors, [e.target.name]: null }); // reset erreur sur champ modifié
  };

  const handleImageChange = (e) => {
    const file = e.target.files[0];
    if (file && !file.type.startsWith("image/")) {
      setErrors({ ...errors, image: "Le fichier doit être une image." });
      setImage(null);
      setPreviewImage(null);
      return;
    }
    setErrors({ ...errors, image: null });
    setImage(file);
    if (file) {
      setPreviewImage(URL.createObjectURL(file));
    }
  };

  const handleSubmit = async (e) => {
    e.preventDefault();

    setErrorMessage("");
    setSuccessMessage("");
    setErrors({});

    // Validation simple
    if (!category.name.trim()) {
      setErrors({ name: "Le nom est obligatoire." });
      return;
    }

    const result = await Swal.fire({
      title: "Confirmer la modification",
      text: "Voulez-vous modifier cette catégorie ?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Oui, modifier",
      cancelButtonText: "Annuler",
    });

    if (!result.isConfirmed) return;

    const formData = new FormData();
    formData.append("name", category.name);
    formData.append("description", category.description);
    formData.append("prix", category.prix);
    if (image) formData.append("image", image);
    formData.append("_method", "PUT");

    try {
      const res = await fetch(`http://127.0.0.1:8000/api/categories/${id}`, {
        method: "POST",
        headers: {
          Accept: "application/json",
        },
        body: formData,
      });

      const data = await res.json();

      if (!res.ok) {
        if (data.errors) {
          setErrors(data.errors);
        }
        throw new Error(data.message || "Erreur lors de la mise à jour");
      }

      setSuccessMessage("Catégorie mise à jour avec succès !");
      Swal.fire("Succès", "Catégorie mise à jour avec succès", "success");
      setTimeout(() => navigate("/Formateur/CategoryList"), 2000);
    } catch (error) {
      setErrorMessage(error.message || "Erreur lors de la mise à jour");
      Swal.fire("Erreur", error.message || "Échec de la mise à jour", "error");
    }
  };

  return (
    <Container>
      <Row className="justify-content-center mt-4">
        <Col md={7}>
          <Card className="shadow-sm rounded-3">
            <Card.Header className="bg-primary text-white text-center">
              <h4>Modifier la catégorie</h4>
            </Card.Header>
            <Card.Body>
              {successMessage && <Alert variant="success">{successMessage}</Alert>}
              {errorMessage && <Alert variant="danger">{errorMessage}</Alert>}
              <Form onSubmit={handleSubmit} encType="multipart/form-data">
                <Form.Group className="mb-3">
                  <Form.Label>Nom</Form.Label>
                  <Form.Control
                    type="text"
                    name="name"
                    value={category.name}
                    onChange={handleChange}
                    isInvalid={!!errors.name}
                  />
                  <Form.Control.Feedback type="invalid">{errors.name}</Form.Control.Feedback>
                </Form.Group>

                <Form.Group className="mb-3">
                  <Form.Label>Description</Form.Label>
                  <Form.Control
                    as="textarea"
                    name="description"
                    value={category.description}
                    onChange={handleChange}
                    isInvalid={!!errors.description}
                  />
                  <Form.Control.Feedback type="invalid">{errors.description}</Form.Control.Feedback>
                </Form.Group>

                <Form.Group className="mb-3">
                  <Form.Label>Prix</Form.Label>
                  <Form.Control
                    type="number"
                    name="prix"
                    value={category.prix}
                    onChange={handleChange}
                    isInvalid={!!errors.prix}
                  />
                  <Form.Control.Feedback type="invalid">{errors.prix}</Form.Control.Feedback>
                </Form.Group>

                <Form.Group className="mb-3">
                  <Form.Label>Image</Form.Label>
                  <Form.Control
                    type="file"
                    accept="image/*"
                    onChange={handleImageChange}
                    isInvalid={!!errors.image}
                  />
                  <Form.Control.Feedback type="invalid">{errors.image}</Form.Control.Feedback>
                  {previewImage && (
                    <div className="mt-3">
                      <img src={previewImage} alt="Aperçu" className="img-thumbnail" width="150" />
                    </div>
                  )}
                </Form.Group>

                <Button variant="primary" type="submit" className="w-100 mb-2">
                  Mettre à jour
                </Button>
                <Button variant="secondary" onClick={() => navigate("/Formateur/CategoryList")} className="w-100">
                  Annuler
                </Button>
              </Form>
            </Card.Body>
          </Card>
        </Col>
      </Row>
    </Container>
  );
};

export default EditCategory;
