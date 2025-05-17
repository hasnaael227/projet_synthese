import React, { useEffect, useState } from "react";
import { useParams, useNavigate } from "react-router-dom";
import { Alert, Button, Card, Form, Container, Row, Col } from "react-bootstrap";
import Swal from "sweetalert2";

const EditUsers = () => {
  const { id } = useParams();
  const navigate = useNavigate();

  const [user, setUser] = useState({
    matricule: "",
    name: "",
    prename: "",
    email: "",
    role: "",
    image: "",
  });
  const [image, setImage] = useState(null);
  const [previewImage, setPreviewImage] = useState(null);
  const [errors, setErrors] = useState({});
  const [errorMessage, setErrorMessage] = useState("");
  const [successMessage, setSuccessMessage] = useState("");

  // Charger les infos de l'utilisateur
  useEffect(() => {
    fetch(`http://127.0.0.1:8000/api/users/${id}`)
      .then((res) => {
        if (!res.ok) throw new Error("Erreur lors du chargement");
        return res.json();
      })
      .then((data) => {
        setUser(data);
        if (data.image) {
          setPreviewImage(`http://127.0.0.1:8000/storage/${data.image}`);
        }
      })
      .catch((error) => {
        setErrorMessage(error.message || "Erreur de chargement des données");
      });
  }, [id]);

  const handleChange = (e) => {
    setUser({ ...user, [e.target.name]: e.target.value });
    setErrors({ ...errors, [e.target.name]: null }); // reset erreur sur champ modifié
  };

  const handleImageChange = (e) => {
    const file = e.target.files[0];
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

    const formData = new FormData();
    formData.append("matricule", user.matricule);
    formData.append("name", user.name);
    formData.append("prename", user.prename);
    formData.append("email", user.email);
    formData.append("role", user.role);
    if (image) formData.append("image", image);
    formData.append("_method", "PUT"); // pour Laravel

    try {
      const res = await fetch(`http://127.0.0.1:8000/api/users/${id}`, {
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

      setSuccessMessage("Utilisateur mis à jour avec succès !");
      Swal.fire("Succès", "Utilisateur mis à jour avec succès", "success");
      setTimeout(() => navigate("/admin/ListUsers"), 2000);
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
              <h4>Modifier l'utilisateur</h4>
            </Card.Header>
            <Card.Body>
              {successMessage && <Alert variant="success">{successMessage}</Alert>}
              {errorMessage && <Alert variant="danger">{errorMessage}</Alert>}
              <Form onSubmit={handleSubmit} encType="multipart/form-data">
                <Form.Group className="mb-3">
                  <Form.Label>Matricule</Form.Label>
                  <Form.Control
                    type="text"
                    name="matricule"
                    value={user.matricule}
                    onChange={handleChange}
                    isInvalid={!!errors.matricule}
                  />
                  <Form.Control.Feedback type="invalid">{errors.matricule}</Form.Control.Feedback>
                </Form.Group>

                <Form.Group className="mb-3">
                  <Form.Label>Nom</Form.Label>
                  <Form.Control
                    type="text"
                    name="name"
                    value={user.name}
                    onChange={handleChange}
                    isInvalid={!!errors.name}
                  />
                  <Form.Control.Feedback type="invalid">{errors.name}</Form.Control.Feedback>
                </Form.Group>

                <Form.Group className="mb-3">
                  <Form.Label>Prénom</Form.Label>
                  <Form.Control
                    type="text"
                    name="prename"
                    value={user.prename}
                    onChange={handleChange}
                    isInvalid={!!errors.prename}
                  />
                  <Form.Control.Feedback type="invalid">{errors.prename}</Form.Control.Feedback>
                </Form.Group>

                <Form.Group className="mb-3">
                  <Form.Label>Email</Form.Label>
                  <Form.Control
                    type="email"
                    name="email"
                    value={user.email}
                    onChange={handleChange}
                    isInvalid={!!errors.email}
                  />
                  <Form.Control.Feedback type="invalid">{errors.email}</Form.Control.Feedback>
                </Form.Group>

                <Form.Group className="mb-3">
                  <Form.Label>Rôle</Form.Label>
                  <Form.Select
                    name="role"
                    value={user.role}
                    onChange={handleChange}
                    isInvalid={!!errors.role}
                  >
                    <option value="">Sélectionnez un rôle</option>
                    <option value="admin">Admin</option>
                    <option value="formateur">Formateur</option>
                    <option value="employee">Employé</option>
                  </Form.Select>
                  <Form.Control.Feedback type="invalid">{errors.role}</Form.Control.Feedback>
                </Form.Group>

                <Form.Group className="mb-3">
                  <Form.Label>Image de profil</Form.Label>
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
                  Enregistrer les modifications
                </Button>
                <Button variant="secondary" onClick={() => navigate("/admin/ListUsers")} className="w-100">
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

export default EditUsers;
