import React, { useState, useEffect } from "react";
import axios from "axios";
import Swal from "sweetalert2";
import { useNavigate } from "react-router-dom";
import { Form, Button, Container, Row, Col, Alert, Card } from "react-bootstrap";

const AddChapitre = () => {
  const [titre, setTitre] = useState("");
  const [category_id, setCategoryId] = useState("");
  const [categories, setCategories] = useState([]);
  const [errors, setErrors] = useState({});
  const [errorMessage, setErrorMessage] = useState("");

  const navigate = useNavigate(); // pour la redirection

  useEffect(() => {
    axios
      .get("http://localhost:8000/api/categories")
      .then((res) => {
        setCategories(res.data);
      })
      .catch(() => {
        setErrorMessage("Erreur lors du chargement des catégories.");
      });
  }, []);

  const handleSubmit = async (e) => {
    e.preventDefault();
    setErrors({});
    setErrorMessage("");

    try {
      await axios.post("http://localhost:8000/api/chapitres", {
        titre,
        category_id,
      });

      Swal.fire({
        icon: "success",
        title: "Succès",
        text: "Chapitre ajouté avec succès !",
        confirmButtonText: "OK",
      }).then(() => {
        navigate("/Formateur/ListChapitres"); // Redirection vers la liste
      });

      setTitre("");
      setCategoryId("");
    } catch (err) {
      if (err.response && err.response.status === 422) {
        setErrors(err.response.data.errors || {});
      } else {
        setErrorMessage("Une erreur est survenue.");
      }
    }
  };

  return (
    <Container className="mt-5">
      <Row className="justify-content-center">
        <Col md={6}>
          <Card className="shadow-sm">
            <Card.Header className="bg-primary text-white text-center">
              <h4>Ajouter un chapitre</h4>
            </Card.Header>
            <Card.Body>
              {errorMessage && <Alert variant="danger">{errorMessage}</Alert>}
              <Form onSubmit={handleSubmit}>
                <Form.Group className="mb-3">
                  <Form.Label>Titre du chapitre</Form.Label>
                  <Form.Control
                    type="text"
                    value={titre}
                    onChange={(e) => setTitre(e.target.value)}
                    isInvalid={!!errors.titre}
                  />
                  <Form.Control.Feedback type="invalid">
                    {errors.titre}
                  </Form.Control.Feedback>
                </Form.Group>

                <Form.Group className="mb-3">
                  <Form.Label>Catégorie</Form.Label>
                  <Form.Select
                    value={category_id}
                    onChange={(e) => setCategoryId(e.target.value)}
                    isInvalid={!!errors.category_id}
                  >
                    <option value="">-- Sélectionnez une catégorie --</option>
                    {categories.map((cat) => (
                      <option key={cat.id} value={cat.id}>
                        {cat.name}
                      </option>
                    ))}
                  </Form.Select>
                  <Form.Control.Feedback type="invalid">
                    {errors.category_id}
                  </Form.Control.Feedback>
                </Form.Group>

                <Button variant="primary" type="submit" className="w-100">
                  Ajouter
                </Button>
              </Form>
            </Card.Body>
          </Card>
        </Col>
      </Row>
    </Container>
  );
};

export default AddChapitre;
