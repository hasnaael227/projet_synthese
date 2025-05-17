import React from 'react';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap-icons/font/bootstrap-icons.css';
import { Link } from "react-router-dom";

import {
  LineChart, Line, CartesianGrid, XAxis, YAxis, Tooltip, ResponsiveContainer,
} from 'recharts';

const AdminDashboard = () => {
  const data = [
    { name: 'Jan', cours: 5, quiz: 2 },
    { name: 'Fév', cours: 8, quiz: 4 },
    { name: 'Mars', cours: 12, quiz: 6 },
  ];

  return (
    <div className="container mt-4">

      <h2 className="mb-4">Tableau de Bord – Gestion Admin</h2>

      {/* Statistiques principales */}
      <div className="row g-4">
        <div className="col-md-4">
          <div className="card text-white bg-primary shadow">
            <div className="card-body">
              <h5 className="card-title"><i className="bi bi-people-fill me-2"></i>Formateurs</h5>
              <p className="card-text fs-4">36</p>
            </div>
          </div>
        </div>

        <div className="col-md-4">
          <div className="card text-white bg-info shadow">
            <div className="card-body">
              <h5 className="card-title"><i className="bi bi-journal-bookmark-fill me-2"></i>Cours</h5>
              <p className="card-text fs-4">12 modules</p>
            </div>
          </div>
        </div>

        <div className="col-md-4">
          <div className="card text-white bg-warning shadow">
            <div className="card-body">
              <h5 className="card-title"><i className="bi bi-patch-question-fill me-2"></i>Quiz</h5>
              <p className="card-text fs-4">7 actifs</p>
            </div>
          </div>
        </div>
      </div>

    

      {/* Actions rapides */}
      <div className="mt-5">
        <h4 className="mb-3">Actions rapides</h4>
        <div className="row g-3">
          <div className="col-md-3">
            <Link to='/Admin/ListUsers' className="btn btn-outline-primary w-100 ">
              <i className="bi bi-person-lines-fill me-1"></i> Gérer les formateurs
            </Link>
          </div>
          <div className="col-md-3">
            <Link to="/Admin/ListCours" className="btn btn-outline-info w-100">
              <i className="bi bi-journal-text me-1"></i> Gérer les cours
            </Link>
          </div>
          <div className="col-md-3">
            <Link to="/Admin/quizzes" className="btn btn-outline-warning w-100">
              <i className="bi bi-patch-question me-1"></i> Gérer les quiz
            </Link>
          </div>
          
        </div>
      </div>

      {/* Historique */}
      <div className="mt-5">
        <h4>Historique récent</h4>
        <ul className="list-group">
          <li className="list-group-item">Nouveau cours ajouté : <strong>React Avancé</strong></li>
          <li className="list-group-item">Quiz "Sécurité Web" publié</li>
          <li className="list-group-item">Absence validée pour <strong>Karim B.</strong></li>
        </ul>
      </div>

      {/* Derniers utilisateurs */}
      <div className="mt-5">
        <h4>Derniers utilisateurs</h4>
        <ul className="list-group">
          <li className="list-group-item d-flex justify-content-between">
            <span><i className="bi bi-person-circle me-2"></i> Sarah M.</span>
            <span className="badge bg-success">Aujourd'hui</span>
          </li>
          <li className="list-group-item d-flex justify-content-between">
            <span><i className="bi bi-person-circle me-2"></i> Yassine T.</span>
            <span className="badge bg-secondary">Il y a 2 jours</span>
          </li>
        </ul>
      </div>
  {/* Graphique */}
      <div className="mt-5">
        <h4>Statistiques d’évolution</h4>
        <ResponsiveContainer width="100%" height={300}>
          <LineChart data={data}>
            <Line type="monotone" dataKey="cours" stroke="#0d6efd" strokeWidth={2} />
            <Line type="monotone" dataKey="quiz" stroke="#ffc107" strokeWidth={2} />
            <CartesianGrid stroke="#ccc" />
            <XAxis dataKey="name" />
            <YAxis />
            <Tooltip />
          </LineChart>
        </ResponsiveContainer>
      </div>
      {/* Activité système */}
     
    </div>
  );
};

export default AdminDashboard;
