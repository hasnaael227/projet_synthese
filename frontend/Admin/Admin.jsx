import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap-icons/font/bootstrap-icons.css';

const Admin = () => {
  const navigate = useNavigate();
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [apiError, setApiError] = useState(null);
  const [isSubmitting, setIsSubmitting] = useState(false);

  const redirectUser = (role, redirect) => {
    if (redirect) {
      navigate(redirect);
    } else {
      switch(role) {
        case 'admin':
          navigate('/Admin/AdminDashboard');
          break;
        case 'formateur':
          navigate('/Formateur/FormateurDashboard');
          break;
        default:
          navigate('/');
      }
    }
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setApiError(null);
    setIsSubmitting(true);

    try {
      const response = await fetch('http://127.0.0.1:8000/api/login', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ email, password }),
      });

      const data = await response.json();

      if (response.ok) {
        localStorage.setItem('token', data.token);
        localStorage.setItem('user', JSON.stringify(data.user));
        localStorage.setItem('role', data.user.role);

        redirectUser(data.user.role, data.redirect);
      } else {
        setApiError(data.message || 'Identifiants incorrects');
      }
    } catch {
      setApiError('Erreur de connexion au serveur');
    } finally {
      setIsSubmitting(false);
    }
  };

  return (
    <div className="container-fluid bg-light min-vh-100 d-flex justify-content-center align-items-center">
      <div className="card shadow-lg border-0 p-4" style={{ width: '100%', maxWidth: '420px' }}>
        <div className="text-center mb-4">
          <i className="bi bi-person-lock" style={{ fontSize: '3rem', color: '#0d6efd' }}></i>
          <h3 className="mt-2">Login</h3>
        </div>

        {apiError && <div className="alert alert-danger">{apiError}</div>}

        <form onSubmit={handleSubmit}>
          <div className="form-group mb-3">
            <label htmlFor="email" className="form-label">Email</label>
            <div className="input-group">
              <span className="input-group-text"><i className="bi bi-envelope"></i></span>
              <input
                type="email"
                className="form-control"
                id="email"
                placeholder="admin@skillup.com"
                value={email}
                onChange={(e) => setEmail(e.target.value)}
                required
              />
            </div>
          </div>

          <div className="form-group mb-3">
            <label htmlFor="password" className="form-label">Mot de passe</label>
            <div className="input-group">
              <span className="input-group-text"><i className="bi bi-lock"></i></span>
              <input
                type="password"
                className="form-control"
                id="password"
                placeholder="••••••••"
                value={password}
                onChange={(e) => setPassword(e.target.value)}
                required
              />
            </div>
          </div>

          <button type="submit" className="btn btn-primary w-100 mt-3" disabled={isSubmitting}>
            <i className="bi bi-box-arrow-in-right me-2"></i>
            {isSubmitting ? 'Connexion en cours...' : 'Se connecter'}
          </button>
        </form>

        <div className="text-center mt-3">
          <small>
            Retour à l'accueil ? <a href="/" className="text-decoration-none">Cliquez ici</a>
          </small>
        </div>
      </div>
    </div>
  );
};

export default Admin;
