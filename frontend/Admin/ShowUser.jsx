import React, { useEffect, useState } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import axios from 'axios';
import { Card, Button, Container, Row, Col, Spinner, Alert } from 'react-bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';

const ShowUser = () => {
  const { id } = useParams();
  const navigate = useNavigate();
  const [user, setUser] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState('');

  useEffect(() => {
    const fetchUser = async () => {
      try {
        const res = await axios.get(`http://127.0.0.1:8000/api/users/${id}`);
        setUser(res.data);
      } catch (err) {
        setError("Impossible de récupérer l'utilisateur.");
      } finally {
        setLoading(false);
      }
    };
    fetchUser();
  }, [id]);

  const handleBack = () => {
    navigate('/admin/ListUsers');
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

  return (
    <Container className="mt-5">
      <Row className="justify-content-center">
        <Col md={8}>
          <Card className="shadow rounded">
            <Card.Header className="bg-primary text-white text-center">
              <h4>Détails de l'utilisateur</h4>
            </Card.Header>
            <Card.Body>
              <Row>
                <Col md={4} className="text-center mb-3">
                  <img
                    src={user.image ? `http://127.0.0.1:8000/storage/${user.image}` : 'https://via.placeholder.com/150'}
                    alt="Profil"
                    className="img-fluid rounded-circle shadow"
                    width="150"
                  />
                </Col>
                <Col md={8}>
                  <p><strong>Matricule :</strong> {user.matricule}</p>
                  <p><strong>Nom :</strong> {user.name}</p>
                  <p><strong>Prénom :</strong> {user.prename}</p>
                  <p><strong>Email :</strong> {user.email}</p>
                  <p><strong>Rôle :</strong> {user.role === 'admin' ? 'Administrateur' : 'Formateur'}</p>
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

export default ShowUser;
