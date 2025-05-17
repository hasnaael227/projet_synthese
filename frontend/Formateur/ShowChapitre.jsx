import React, { useEffect, useState } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import axios from 'axios';
import { Card, Button, Container, Row, Col, Spinner, Alert } from 'react-bootstrap';

const ShowChapitre = () => {
  const { id } = useParams();
  const navigate = useNavigate();
  const [chapitre, setChapitre] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState('');

  useEffect(() => {
    const fetchChapitre = async () => {
      try {
        const res = await axios.get(`http://localhost:8000/api/chapitres/${id}`);
        setChapitre(res.data);
      } catch (err) {
        setError("Impossible de récupérer le chapitre.");
      } finally {
        setLoading(false);
      }
    };
    fetchChapitre();
  }, [id]);

  const handleBack = () => {
    navigate('/Formateur/ListChapitres');  // adapte selon ta route de liste chapitres
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

  if (!chapitre) {
    return (
      <Container className="mt-5">
        <Alert variant="warning">Chapitre non trouvé.</Alert>
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
              <h4>Détails du Chapitre</h4>
            </Card.Header>
            <Card.Body>
              <p><strong>Titre :</strong> {chapitre.titre}</p>
              <p><strong>Catégorie :</strong> {chapitre.category?.name || 'Non défini'}</p>

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

export default ShowChapitre;
