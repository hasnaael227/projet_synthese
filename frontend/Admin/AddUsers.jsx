import React, { useState, useEffect } from 'react';
import { useForm } from 'react-hook-form';
import { zodResolver } from '@hookform/resolvers/zod';
import { z } from 'zod';
import { Alert, Button, Card, Form, Container, Row, Col } from 'react-bootstrap';
import { useNavigate } from 'react-router-dom';
import axios from 'axios';
import Swal from 'sweetalert2';
import 'bootstrap/dist/css/bootstrap.min.css';



const formSchema = z.object({
    matricule: z.string().min(1, 'Matricule requis').max(30),
    name: z.string().min(1, 'Nom requis').max(30),
    prename: z.string().min(1, 'Prénom requis').max(30),
    email: z.string().email("Email invalide"),
    password: z.string().min(6, 'Au moins 6 caractères'),
    confirmPassword: z.string().min(6, 'Confirmer le mot de passe'),
    role: z.enum(['admin', 'formateur'], { message: 'Sélectionnez un rôle' }),
    image: z.any().optional(),
}).refine((data) => data.password === data.confirmPassword, {
    message: 'Les mots de passe ne correspondent pas',
    path: ['confirmPassword'],
});

const AddUsers = () => {
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
        return () => previewImage && URL.revokeObjectURL(previewImage);
    }, [previewImage]);

    const onSubmit = async (data) => {
        const formData = new FormData();
        Object.entries(data).forEach(([key, value]) => {
            if (key !== 'confirmPassword') {
                formData.append(key, value);
            }
        });
        formData.append('password_confirmation', data.confirmPassword);

        const confirm = await Swal.fire({
            title: 'Confirmer ajout',
            text: "Voulez-vous vraiment ajouter cet utilisateur ?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Oui',
            cancelButtonText: 'Non',
        });

        if (!confirm.isConfirmed) return;

        try {
            await axios.post('http://127.0.0.1:8000/api/users', formData, {
                headers: { 'Content-Type': 'multipart/form-data' },
            });

            setSuccessMessage('Utilisateur ajouté avec succès !');
            setErrorMessage('');

            await Swal.fire('Ajouté !', 'L\'utilisateur a été enregistré.', 'success');
            navigate('/admin/ListUsers');
        } catch (err) {
            console.error(err);
            setErrorMessage(err.response?.data?.message || "Erreur lors de l'ajout.");
            await Swal.fire('Erreur', errorMessage, 'error');
        }
    };

    const handleImageChange = (e) => {
        const file = e.target.files[0];
        if (file) {
            setPreviewImage(URL.createObjectURL(file));
            setValue('image', file);
        }
    };

    return (
        <Container>
            <Row className="justify-content-center">
                <Col md={8}>
                    <Card className="shadow-sm rounded-3 mt-4">
                        <Card.Header className="bg-primary text-white text-center">
                            <h4>Ajouter un formateur / utilisateur</h4>
                        </Card.Header>
                        <Card.Body>
                            {successMessage && <Alert variant="success">{successMessage}</Alert>}
                            {errorMessage && <Alert variant="danger">{errorMessage}</Alert>}
                            {Object.keys(errors).length > 0 && (
                                <Alert variant="danger">Veuillez corriger les erreurs ci-dessous.</Alert>
                            )}

                            <Form onSubmit={handleSubmit(onSubmit)}>
                                <Form.Group className="mb-3">
                                    <Form.Label>Matricule</Form.Label>
                                    <Form.Control type="text" {...register('matricule')} isInvalid={!!errors.matricule} />
                                    <Form.Control.Feedback type="invalid">{errors.matricule?.message}</Form.Control.Feedback>
                                </Form.Group>

                                <Form.Group className="mb-3">
                                    <Form.Label>Nom</Form.Label>
                                    <Form.Control type="text" {...register('name')} isInvalid={!!errors.name} />
                                    <Form.Control.Feedback type="invalid">{errors.name?.message}</Form.Control.Feedback>
                                </Form.Group>

                                <Form.Group className="mb-3">
                                    <Form.Label>Prénom</Form.Label>
                                    <Form.Control type="text" {...register('prename')} isInvalid={!!errors.prename} />
                                    <Form.Control.Feedback type="invalid">{errors.prename?.message}</Form.Control.Feedback>
                                </Form.Group>

                                <Form.Group className="mb-3">
                                    <Form.Label>Email</Form.Label>
                                    <Form.Control type="email" {...register('email')} isInvalid={!!errors.email} />
                                    <Form.Control.Feedback type="invalid">{errors.email?.message}</Form.Control.Feedback>
                                </Form.Group>

                                <Form.Group className="mb-3">
                                    <Form.Label>Mot de passe</Form.Label>
                                    <Form.Control type="password" {...register('password')} isInvalid={!!errors.password} />
                                    <Form.Control.Feedback type="invalid">{errors.password?.message}</Form.Control.Feedback>
                                </Form.Group>

                                <Form.Group className="mb-3">
                                    <Form.Label>Confirmation</Form.Label>
                                    <Form.Control type="password" {...register('confirmPassword')} isInvalid={!!errors.confirmPassword} />
                                    <Form.Control.Feedback type="invalid">{errors.confirmPassword?.message}</Form.Control.Feedback>
                                </Form.Group>

                                <Form.Group className="mb-3">
                                    <Form.Label>Rôle</Form.Label>
                                    <Form.Select {...register('role')} isInvalid={!!errors.role}>
                                        <option value="">-- Sélectionner un rôle --</option>
                                        <option value="admin">Admin</option>
                                        <option value="formateur">Formateur</option>
                                    </Form.Select>
                                    <Form.Control.Feedback type="invalid">{errors.role?.message}</Form.Control.Feedback>
                                </Form.Group>

                                <Form.Group className="mb-3">
                                    <Form.Label>Image (optionnelle)</Form.Label>
                                    <Form.Control type="file" onChange={handleImageChange} />
                                    {previewImage && <img src={previewImage} alt="Aperçu" className="img-thumbnail mt-2" width="150" />}
                                </Form.Group>

                                <Button type="submit" variant="primary" className="w-100 mb-2" disabled={isSubmitting}>
                                    {isSubmitting ? 'Ajout en cours...' : 'Ajouter'}
                                </Button>
                                <Button variant="secondary" className="w-100" onClick={() => navigate('/admin/ListUsers')}>
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

export default AddUsers;
