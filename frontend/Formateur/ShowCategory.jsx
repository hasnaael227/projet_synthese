import React, { useEffect, useState } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import axios from 'axios';
import { Card, Button, Container, Row, Col, Spinner, Alert } from 'react-bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';

const ShowCategory = () => {
  const { id } = useParams();
  const navigate = useNavigate();
  const [category, setCategory] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState('');

  useEffect(() => {
    const fetchCategory = async () => {
      try {
        const res = await axios.get(`http://127.0.0.1:8000/api/categories/${id}`);
        setCategory(res.data);
      } catch (err) {
        setError("Impossible de récupérer la catégorie.");
      } finally {
        setLoading(false);
      }
    };
    fetchCategory();
  }, [id]);

  const handleBack = () => {
    navigate('/Formateur/CategoryList');  // adapte selon ta route de liste catégories
  };

  if (loading) {
    return (
      <div className="d-flex justify-content-center mt-5">
        <Spinner animation="border" variant="primary" />
      </div>
    );
  }

  if (error) {
    return (
      <Container className="mt-5">
        <Alert variant="danger">{error}</Alert>
        <Button variant="secondary" onClick={handleBack}>Retour</Button>
      </Container>
    );
  }

  if (!category) {
    return (
      <Container className="mt-5">
        <Alert variant="warning">Catégorie non trouvée.</Alert>
        <Button variant="secondary" onClick={handleBack}>Retour</Button>
      </Container>
    );
  }

  return (
    <Container className="mt-5">
      <Row className="justify-content-center">
        <Col md={8}>
          <Card className="shadow rounded">
            <Card.Header className="bg-primary text-white text-center">
              <h4>Détails de la catégorie</h4>
            </Card.Header>
            <Card.Body>
              <Row>
                <Col md={4} className="text-center mb-3">
                  <img
                    src={category.image ? `http://127.0.0.1:8000/storage/${category.image}` : 'https://via.placeholder.com/150'}
                    alt="Image catégorie"
                    className="img-fluid rounded shadow"
                    style={{ maxHeight: '150px', objectFit: 'cover' }}
                  />
                </Col>
                <Col md={8}>
                  <p><strong>Nom :</strong> {category.name}</p>
                  <p><strong>Description :</strong> {category.description || 'Aucune description'}</p>
                  <p><strong>Prix :</strong> {category.prix !== null ? `${category.prix} €` : 'Non renseigné'}</p>
                </Col>
              </Row>
              <div className="d-flex justify-content-end mt-4">
                <Button variant="secondary" onClick={handleBack}>Retour à la liste</Button>
              </div>
            </Card.Body>
          </Card>
        </Col>
      </Row>
    </Container>
  );
};

export default ShowCategory;
