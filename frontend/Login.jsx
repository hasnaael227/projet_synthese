import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import Swal from 'sweetalert2';
import 'bootstrap/dist/css/bootstrap.min.css';

const Login = () => {
  const navigate = useNavigate();
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');

  const handleSubmit = async (e) => {
    e.preventDefault();

    try {
      const response = await fetch('http://localhost:8000/api/etudiants/login', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json'
        },
        body: JSON.stringify({ email, password })
      });

      const data = await response.json();

      if (response.ok && data.token) {
        localStorage.setItem('token', data.token);

        Swal.fire({
          icon: 'success',
          title: 'Connexion réussie',
          showConfirmButton: false,
          timer: 1500
        });

        navigate('/');
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Échec de la connexion',
          text: data.message || 'Identifiants incorrects'
        });
      }
    } catch (error) {
      console.error('Erreur lors de la connexion :', error);
      Swal.fire({
        icon: 'error',
        title: 'Erreur serveur',
        text: 'Une erreur est survenue. Veuillez réessayer.'
      });
    }
  };

  return (
    <div className="container d-flex justify-content-center align-items-center min-vh-100">
      <div className="card p-4 shadow" style={{ width: '100%', maxWidth: '400px' }}>
        <h3 className="text-center mb-4">Connexion</h3>
        <form onSubmit={handleSubmit}>
          <div className="mb-3">
            <label htmlFor="email" className="form-label">Adresse Email</label>
            <input
              type="email"
              id="email"
              className="form-control"
              placeholder="exemple@domaine.com"
              value={email}
              onChange={(e) => setEmail(e.target.value)}
              required
            />
          </div>

          <div className="mb-3">
            <label htmlFor="password" className="form-label">Mot de passe</label>
            <input
              type="password"
              id="password"
              className="form-control"
              placeholder="••••••••"
              value={password}
              onChange={(e) => setPassword(e.target.value)}
              required
            />
          </div>

          <button type="submit" className="btn btn-primary w-100">Se connecter</button>
        </form>

        <div className="text-center mt-3">
          <small>Vous n'avez pas de compte ? <a href="/register">Inscrivez-vous</a></small>
        </div>
      </div>
    </div>
  );
};

export default Login;
