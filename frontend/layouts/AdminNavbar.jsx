import React from 'react';
import { Link, useNavigate } from 'react-router-dom';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap-icons/font/bootstrap-icons.css';
import '../components/style/Navbar.css';

const AdminNavbar = () => {
  const navigate = useNavigate();
  const role = localStorage.getItem('role'); // Récupère le rôle stocké

  const handleLogout = () => {
    // Nettoyage éventuel
    localStorage.removeItem('role');
    navigate('/admin');
  };

  return (
    <>
      <br /><br /><br /><br />
      <nav className="navbar navbar-expand-lg navbar-dark bg-primary shadow fixed-top">
        <div className="container-fluid">
          <Link className="navbar-brand d-flex align-items-center" to="#">
            <i className="bi bi-shield-lock-fill me-2"></i>
            SkillUp
          </Link>

          <button className="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
            <span className="navbar-toggler-icon"></span>
          </button>

          <div className="collapse navbar-collapse" id="adminNavbar">
            <ul className="navbar-nav ms-auto mb-2 mb-lg-0">
              {/* Liens pour Admin */}
              {role === 'admin' && (
                <>
                  <li className="nav-item">
                    <Link className="nav-link" to="/Admin/AdminDashboard"><i className="bi bi-speedometer2 me-1"></i>Dashboard</Link>
                  </li>
                  <li className="nav-item">
                    <Link className="nav-link" to="/Admin/ListUsers"><i className="bi bi-people me-1"></i>Utilisateurs</Link>
                  </li>
                  <li className="nav-item">
                    <Link className="nav-link" to="/Admin/ListCours"><i className="bi bi-journal-text me-1"></i>Cours</Link>
                  </li>
                  <li className="nav-item">
                    <Link className="nav-link" to="/Admin/settings"><i className="bi bi-gear me-1"></i>Paramètres</Link>
                  </li>
                </>
              )}

              {/* Liens pour Formateur */}
              {role === 'formateur' && (
                <>
                  <li className="nav-item">
                    <Link className="nav-link" to="/Formateur/FormateurDashboard"><i className="bi bi-speedometer2 me-1"></i>Dashboard</Link>
                  </li>
                  <li className="nav-item">
                    <Link className="nav-link" to="/Formateur/Cours"><i className="bi bi-journal-text me-1"></i>Mes Cours</Link>
                  </li>
                   <li className="nav-item">
                    <Link className="nav-link" to="/Formateur/CategoryList"><i className="bi bi-journal-text me-1"></i>Mes categories</Link>
                  </li>
                  <li className="nav-item">
                    <Link className="nav-link" to="/Formateur/Etudiants"><i className="bi bi-people me-1"></i>Étudiants</Link>
                  </li>
                </>
              )}

              {/* Déconnexion visible pour tous */}
              <li className="nav-item">
                <button className="btn btn-danger btn-outline-light ms-3" onClick={handleLogout}>
                  <i className="bi bi-box-arrow-right me-1"></i>Déconnexion
                </button>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </>
  );
};

export default AdminNavbar;
