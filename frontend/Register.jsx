import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import Swal from 'sweetalert2';
import 'bootstrap/dist/css/bootstrap.min.css';

const Register = () => {
  const navigate = useNavigate();
  const [formData, setFormData] = useState({
    nom: '',
    prenom: '',
    numTel: '',
    email: '',
    password: '',
    confirmPassword: ''
  });

  const handleChange = (e) => {
    setFormData(prev => ({
      ...prev,
      [e.target.name]: e.target.value
    }));
  };

  const handleSubmit = async (e) => {
    e.preventDefault();

    if (formData.password !== formData.confirmPassword) {
      Swal.fire({
        icon: 'warning',
        title: 'Les mots de passe ne correspondent pas.'
      });
      return;
    }

    try {
      const response = await fetch('http://localhost:8000/api/etudiants', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json'
        },
        body: JSON.stringify({
          nom: formData.nom,
          prenom: formData.prenom,
          numTel: formData.numTel,
          email: formData.email,
          password: formData.password
        })
      });

      const data = await response.json();

      if (response.ok) {
        Swal.fire({
          icon: 'success',
          title: 'Inscription réussie !',
          showConfirmButton: false,
          timer: 1500
        });
        navigate('/login');
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Erreur',
          text: data.message || 'Erreur lors de l’inscription.'
        });
      }
    } catch (error) {
      console.error('Erreur:', error);
      Swal.fire({
        icon: 'error',
        title: 'Erreur serveur',
        text: 'Une erreur est survenue. Veuillez réessayer.'
      });
    }
  };

  return (
    <div className="container d-flex justify-content-center align-items-center min-vh-100">
      <div className="card p-4 shadow" style={{ width: '100%', maxWidth: '450px' }}>
        <h3 className="text-center mb-4">Créer un compte</h3>
        <form onSubmit={handleSubmit}>
          <div className="mb-3">
            <label className="form-label">Nom</label>
            <input type="text" name="nom" className="form-control" value={formData.nom} onChange={handleChange} required />
          </div>

          <div className="mb-3">
            <label className="form-label">Prénom</label>
            <input type="text" name="prenom" className="form-control" value={formData.prenom} onChange={handleChange} required />
          </div>

          <div className="mb-3">
            <label className="form-label">Numéro de téléphone</label>
            <input type="text" name="numTel" className="form-control" value={formData.numTel} onChange={handleChange} required />
          </div>

          <div className="mb-3">
            <label className="form-label">Adresse Email</label>
            <input type="email" name="email" className="form-control" value={formData.email} onChange={handleChange} required />
          </div>

          <div className="mb-3">
            <label className="form-label">Mot de passe</label>
            <input type="password" name="password" className="form-control" value={formData.password} onChange={handleChange} required />
          </div>

          <div className="mb-3">
            <label className="form-label">Confirmer le mot de passe</label>
            <input type="password" name="confirmPassword" className="form-control" value={formData.confirmPassword} onChange={handleChange} required />
          </div>

          <button type="submit" className="btn btn-primary w-100">S'inscrire</button>
        </form>

        <div className="text-center mt-3">
          <small>Vous avez déjà un compte ? <a href="/login">Connectez-vous</a></small>
        </div>
      </div>
    </div>
  );
};

export default Register;
