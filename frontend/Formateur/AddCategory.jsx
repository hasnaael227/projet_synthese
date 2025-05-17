import React, { useState, useEffect } from 'react';
import { useForm } from 'react-hook-form';
import { zodResolver } from '@hookform/resolvers/zod';
import { z } from 'zod';
import { Alert, Button, Card, Form, Container, Row, Col } from 'react-bootstrap';
import { useNavigate } from 'react-router-dom';
import axios from 'axios';
import Swal from 'sweetalert2';
import 'bootstrap/dist/css/bootstrap.min.css';

// Schéma Zod de validation avec validation adaptée pour l'image
const formSchema = z.object({
  name: z.string().min(1, 'Nom requis').max(50),
  description: z.string().optional(),
  prix: z.preprocess(
    (val) => (val === '' ? undefined : Number(val)),
    z.number().positive('Le prix doit être positif').optional()
  ),
  image: z
    .any()
    .refine((files) => {
      if (!files) return true; // image optionnelle
      return files.length === 1 && files[0] instanceof File;
    }, 'Une image valide est requise')
    .optional(),
});

const AddCategory = () => {
  const navigate = useNavigate();

  const {
    register,
    handleSubmit,
    formState: { errors, isSubmitting },
    setValue,
  } = useForm({ resolver: zodResolver(formSchema) });

  const [previewImage, setPreviewImage] = useState(null);
  const [successMessage, setSuccessMessage] = useState('');
  const [errorMessage, setErrorMessage] = useState('');

  useEffect(() => {
    return () => {
      if (previewImage) URL.revokeObjectURL(previewImage);
    };
  }, [previewImage]);

  const onSubmit = async (data) => {
    // DEBUG - vérifier les données reçues
    console.log('Données du formulaire:', data);

    const formData = new FormData();

    formData.append('name', data.name);
    formData.append('description', data.description || '');
    if (data.prix !== undefined) formData.append('prix', data.prix);

    if (data.image && data.image.length > 0) {
      formData.append('image', data.image[0]);
    }

    const confirm = await Swal.fire({
      title: 'Confirmer ajout',
      text: 'Voulez-vous vraiment ajouter cette catégorie ?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Oui',
      cancelButtonText: 'Non',
    });

    if (!confirm.isConfirmed) return;

    try {
      await axios.post('http://127.0.0.1:8000/api/categories', formData, {
        headers: { 'Content-Type': 'multipart/form-data' },
      });

      setSuccessMessage('Catégorie ajoutée avec succès !');
      setErrorMessage('');
      await Swal.fire('Ajouté !', 'La catégorie a été enregistrée.', 'success');
      navigate('/Formateur/CategoryList');
    } catch (err) {
      console.error(err);
      if (err.response?.status === 422) {
        const serverErrors = err.response.data.errors || {};
        let errMsg = 'Erreur de validation :\n';
        for (const key in serverErrors) {
          errMsg += `${key}: ${serverErrors[key].join(', ')}\n`;
        }
        setErrorMessage(errMsg);
        await Swal.fire('Erreur', errMsg, 'error');
      } else {
        const msg = err.response?.data?.message || 'Erreur lors de l\'ajout.';
        setErrorMessage(msg);
        await Swal.fire('Erreur', msg, 'error');
      }
    }
  };

  const handleImageChange = (e) => {
    const file = e.target.files[0];
    if (file) {
      setPreviewImage(URL.createObjectURL(file));
      setValue('image', e.target.files, { shouldValidate: true });
    }
  };

  return (
    <Container>
      <Row className="justify-content-center">
        <Col md={8}>
          <Card className="shadow-sm rounded-3 mt-4">
            <Card.Header className="bg-primary text-white text-center">
              <h4>Ajouter une catégorie</h4>
            </Card.Header>
            <Card.Body>
              {successMessage && <Alert variant="success">{successMessage}</Alert>}
              {errorMessage && <Alert variant="danger" style={{ whiteSpace: 'pre-wrap' }}>{errorMessage}</Alert>}
              {Object.keys(errors).length > 0 && (
                <Alert variant="danger">Veuillez corriger les erreurs ci-dessous.</Alert>
              )}

              <Form onSubmit={handleSubmit(onSubmit)} encType="multipart/form-data">
                <Form.Group className="mb-3" controlId="name">
                  <Form.Label>Nom *</Form.Label>
                  <Form.Control
                    type="text"
                    {...register('name')}
                    isInvalid={!!errors.name}
                    placeholder="Nom de la catégorie"
                  />
                  <Form.Control.Feedback type="invalid">{errors.name?.message}</Form.Control.Feedback>
                </Form.Group>

                <Form.Group className="mb-3" controlId="description">
                  <Form.Label>Description</Form.Label>
                  <Form.Control
                    as="textarea"
                    rows={3}
                    {...register('description')}
                    isInvalid={!!errors.description}
                    placeholder="Description (optionnelle)"
                  />
                  <Form.Control.Feedback type="invalid">{errors.description?.message}</Form.Control.Feedback>
                </Form.Group>

                <Form.Group className="mb-3" controlId="prix">
                  <Form.Label>Prix</Form.Label>
                  <Form.Control
                    type="number"
                    step="0.01"
                    {...register('prix')}
                    isInvalid={!!errors.prix}
                    placeholder="Prix (optionnel)"
                  />
                  <Form.Control.Feedback type="invalid">{errors.prix?.message}</Form.Control.Feedback>
                </Form.Group>

                <Form.Group className="mb-3" controlId="image">
                  <Form.Label>Image (optionnelle)</Form.Label>
                  <Form.Control
                    type="file"
                    accept="image/*"
                    onChange={handleImageChange}
                    isInvalid={!!errors.image}
                  />
                  <Form.Control.Feedback type="invalid">{errors.image?.message}</Form.Control.Feedback>
                  {previewImage && (
                    <img src={previewImage} alt="Aperçu" className="img-thumbnail mt-2" width={150} />
                  )}
                </Form.Group>

                <Button type="submit" variant="primary" className="w-100 mb-2" disabled={isSubmitting}>
                  {isSubmitting ? 'Ajout en cours...' : 'Ajouter'}
                </Button>
                <Button variant="secondary" className="w-100" onClick={() => navigate('/Formateur/CategoryList')}>
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

export default AddCategory;
