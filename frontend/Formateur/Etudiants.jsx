import React from 'react';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap-icons/font/bootstrap-icons.css';

const Etudiants = () => {
  // Exemple de données — à remplacer plus tard par des données dynamiques (via API)
  const etudiants = [
    { id: 1, nom: 'Ahmed Lahmidi', email: 'ahmed@example.com', progression: 85 },
    { id: 2, nom: 'Salma Bensalah', email: 'salma@example.com', progression: 72 },
    { id: 3, nom: 'Youssef El Idrissi', email: 'youssef@example.com', progression: 90 },
    { id: 4, nom: 'Fatima Zahra', email: 'fatima@example.com', progression: 65 },
  ];

  return (
    <div className="container py-5">
      <h2 className="mb-4"><i className="bi bi-people me-2"></i>Liste des étudiants</h2>

      <div className="table-responsive shadow-sm">
        <table className="table table-striped table-bordered align-middle">
          <thead className="table-primary">
            <tr>
              <th>Nom</th>
              <th>Email</th>
              <th>Progression</th>
              <th>Statut</th>
            </tr>
          </thead>
          <tbody>
            {etudiants.map((etudiant, index) => (
              <tr key={etudiant.id}>
                <td>{etudiant.nom}</td>
                <td>{etudiant.email}</td>
                <td>
                  <div className="progress" style={{ height: '20px' }}>
                    <div
                      className="progress-bar"
                      role="progressbar"
                      style={{ width: `${etudiant.progression}%` }}
                    >
                      {etudiant.progression}%
                    </div>
                  </div>
                </td>
                <td>
                  {etudiant.progression >= 75 ? (
                    <span className="badge bg-success">Bon</span>
                  ) : (
                    <span className="badge bg-warning text-dark">À améliorer</span>
                  )}
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>
    </div>
  );
};

export default Etudiants;
