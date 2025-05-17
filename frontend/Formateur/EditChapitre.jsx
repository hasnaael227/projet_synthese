import React, { useEffect, useState } from "react";
import axios from "axios";
import { Form, Button, Container, Row, Col, Alert, Card, Spinner } from "react-bootstrap";
import { useParams, useNavigate } from "react-router-dom";
import Swal from "sweetalert2";

const EditChapitre = () => {
  const { id } = useParams();
  const navigate = useNavigate();

  const [titre, setTitre] = useState("");
  const [category_id, setCategoryId] = useState("");
  const [categories, setCategories] = useState([]);
  const [errors, setErrors] = useState({});
  const [errorMessage, setErrorMessage] = useState("");
  const [loading, setLoading] = useState(true); // loading for fetching chapitre & categories

  useEffect(() => {
    const fetchData = async () => {
      try {
        setLoading(true);
        // fetch categories
        const categoriesResponse = await axios.get("http://localhost:8000/api/categories");
        setCategories(categoriesResponse.data);

        // fetch chapitre data
        const chapitreResponse = await axios.get(`http://localhost:8000/api/chapitres/${id}`);
        setTitre(chapitreResponse.data.titre);
        setCategoryId(chapitreResponse.data.category_id);
        setErrorMessage("");
      } catch (err) {
        setErrorMessage("Erreur lors du chargement des données.");
      } finally {
        setLoading(false);
      }
    };

    fetchData();
  }, [id]);

  const handleSubmit = async (e) => {
    e.preventDefault();
    setErrors({});
    setErrorMessage("");

    try {
      await axios.put(`http://localhost:8000/api/chapitres/${id}`, {
        titre,
        category_id,
      });

      Swal.fire("Succès", "Chapitre mis à jour avec succès !", "success");
      navigate("/Formateur/ListChapitres"); // retour à la liste
    } catch (err) {
      if (err.response && err.response.status === 422) {
        setErrors(err.response.data.errors || {});
      } else {
        setErrorMessage("Une erreur est survenue lors de la mise à jour.");
      }
    }
  };

  if (loading) return <Container className="mt-5 text-center"><Spinner animation="border" /></Container>;

  return (
    <Container className="mt-5">
      <Row className="justify-content-center">
        <Col md={6}>
          <Card className="shadow-sm">
            <Card.Header className="bg-primary text-white text-center">
              <h4>Modifier le chapitre</h4>
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
                  Enregistrer
                </Button>
              </Form>
            </Card.Body>
          </Card>
        </Col>
      </Row>
    </Container>
  );
};

export default EditChapitre;
