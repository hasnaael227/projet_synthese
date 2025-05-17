import React from 'react';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap-icons/font/bootstrap-icons.css';
import { Link } from "react-router-dom";
import { useNavigate } from 'react-router-dom';

const FormateurDashboard = () => {
  const navigate = useNavigate();

 

  return (
    <div className="container-fluid bg-white min-vh-100 p-5">
      {/* En-tête */}
      <div className="d-flex justify-content-between align-items-center mb-5">
        <div>
          <h1 className="text-dark fw-bold">
            <i className="bi bi-mortarboard-fill text-primary me-2"></i>Formateur Dashboard
          </h1>
          <p className="text-muted">Bienvenue ! Gérer vos cours et suivre les progrès de vos étudiants.</p>
        </div>
        
      </div>

      {/* Cartes principales */}
      <div className="row g-4">
        <div className="col-md-6">
          <div className="card h-100 border-0 shadow-sm hover-shadow">
            <div className="card-body text-center">
              <i className="bi bi-journal-bookmark-fill text-primary fs-1 mb-3"></i>
              <h5 className="card-title fw-bold">Gérer les cours</h5>
              <p className="card-text">Créer, éditer et consulter vos modules de formation.</p>
               <Link to='/Formateur/Cours' className="btn btn-outline-primary w-100 ">
               Accéder aux cours
            </Link>
            </div>
          </div>
        </div>

        <div className="col-md-6">
          <div className="card h-100 border-0 shadow-sm hover-shadow">
            <div className="card-body text-center">
              <i className="bi bi-people-fill text-success fs-1 mb-3"></i>
              <h5 className="card-title fw-bold">Suivi des étudiants</h5>
              <p className="card-text">Consultez la progression et l’implication des étudiants.</p>
            <Link to='/Formateur/Etudiants' className="btn btn-outline-success w-100 ">
               Voir les étudiants
            </Link>
            </div>
          </div>
        </div>
      </div>

      {/* Statistiques */}
      <div className="row g-4 mt-4">
        <div className="col-md-4">
          <div className="card text-center shadow-sm border-0 p-3">
            <i className="bi bi-book text-info fs-2 mb-2"></i>
            <h6 className="text-muted">Cours actifs</h6>
            <h3 className="text-dark fw-bold">12</h3>
          </div>
        </div>
        <div className="col-md-4">
          <div className="card text-center shadow-sm border-0 p-3">
            <i className="bi bi-person-check-fill text-success fs-2 mb-2"></i>
            <h6 className="text-muted">Étudiants inscrits</h6>
            <h3 className="text-dark fw-bold">50</h3>
          </div>
        </div>
        <div className="col-md-4">
          <div className="card text-center shadow-sm border-0 p-3">
            <i className="bi bi-bar-chart-line-fill text-warning fs-2 mb-2"></i>
            <h6 className="text-muted">Taux de réussite</h6>
            <h3 className="text-dark fw-bold">80%</h3>
          </div>
        </div>
      </div>
    </div>
  );
};

export default FormateurDashboard;
