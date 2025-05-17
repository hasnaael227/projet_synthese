import React, { useState } from 'react';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap-icons/font/bootstrap-icons.css';
import { Link } from "react-router-dom";

const ListeCours = () => {
  const [cours, setCours] = useState([
    { id: 1, titre: 'Mathématiques', formateur: 'Mme Dupont', niveau: 'Terminale' },
    { id: 2, titre: 'Physique', formateur: 'M. Einstein', niveau: 'Première' },
    { id: 3, titre: 'Informatique', formateur: 'Mme Curie', niveau: 'Licence 1' },
  ]);

  const supprimerCours = (id) => {
    setCours(cours.filter(c => c.id !== id));
  };

  return (
    <div className="container mt-5">
      <h2 className="mb-4">📚 Liste des Cours</h2>
<Link to="" className="btn btn-primary">
       <i className="fa-solid fa-plus"></i> Ajouter un utilisateur
     </Link>
     <br /><br />
      <table className="table table-hover">
        <thead className="table-dark">
          <tr>
            <th>ID</th>
            <th>Titre</th>
            <th>Formateur</th>
            <th>Niveau</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          {cours.length === 0 ? (
            <tr><td colSpan="5" className="text-center">Aucun cours trouvé</td></tr>
          ) : (
            cours.map(c => (
              <tr key={c.id}>
                <td>{c.id}</td>
                <td>{c.titre}</td>
                <td>{c.formateur}</td>
                <td>{c.niveau}</td>
                <td>
                    <button className="btn btn-info btn-action me-1">
                    <i className="bi bi-eye"></i>
                  </button>
                  <button className="btn btn-primary btn-action me-1" >
                    <i className="bi bi-pencil-square"></i>
                  </button>
                  <button className="btn btn-danger btn-action me-1" onClick={() => supprimerCours(c.id)}>
                    <i className="bi bi-trash"></i>
                  </button>
                </td>
              </tr>
            ))
          )}
        </tbody>
      </table>
    </div>
  );
};

export default ListeCours;
