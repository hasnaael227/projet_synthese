import React, { useState } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import 'bootstrap/dist/css/bootstrap.min.css';
import '../components/style/Navbar.css';

const Navbar = () => {
  const [isLoggedIn, setIsLoggedIn] = useState(true); // ⚠️ à remplacer par ta logique réelle d'authentification
  const navigate = useNavigate();

  const handleLogout = () => {
    // Logique de déconnexion (supprimer le token, etc.)
    setIsLoggedIn(false);
    navigate('/');
  };

  return (
    <nav className="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
      <div className="container">
        <Link className="navbar-brand fw-bold text-primary" to="/">SkillUp</Link>

        <button className="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span className="navbar-toggler-icon"></span>
        </button>

        <div className="collapse navbar-collapse" id="navbarNav">
          <ul className="navbar-nav me-auto">
            <li className="nav-item">
              <Link className="nav-link" to="/">Accueil</Link>
            </li>
            <li className="nav-item">
              <Link className="nav-link" to="/cours">Cours</Link>
            </li>
            {isLoggedIn && (
              <li className="nav-item">
                <Link className="nav-link" to="/dashboard">Tableau de bord</Link>
              </li>
            )}
          </ul>
          <div>
            {isLoggedIn ? (
              <button className="btn btn-outline-danger" onClick={handleLogout}>Déconnexion</button>
          
              
            ): (<>
                <Link to="/login" className="btn btn-outline-primary me-2">Connexion</Link>
                <Link to="/register" className="btn btn-primary">Inscription</Link>
              </>)}
          </div>
        </div>
      </div>
    </nav>
  );
};

export default Navbar;
