import React, { useState, useEffect } from 'react';
import 'bootstrap/dist/css/bootstrap.min.css';
import { Link } from "react-router-dom";
import axios from 'axios';
import Swal from 'sweetalert2';

const ListUsers = () => {
  const [search, setSearch] = useState('');
  const [utilisateurs, setUtilisateurs] = useState([]);

  useEffect(() => {
    fetchUtilisateurs();
  }, []);

  const fetchUtilisateurs = async () => {
    try {
      const response = await axios.get('http://localhost:8000/api/users');
      setUtilisateurs(response.data);
    } catch (error) {
      console.error('Erreur lors du chargement des utilisateurs :', error);
    }
  };

  const handleView = (user) => {
    Swal.fire({
      title: `${user.nom} ${user.prenom}`,
      html: `<p>Email : ${user.email}</p><p>Rôle : ${user.role}</p>`,
      icon: 'info'
    });
  };


  const handleDelete = async (user) => {
    const confirmResult = await Swal.fire({
      title: `Supprimer ${user.nom} ?`,
      text: "Cette action est irréversible !",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Oui, supprimer',
      cancelButtonText: 'Annuler'
    });

    if (confirmResult.isConfirmed) {
      try {
        await axios.delete(`http://localhost:8000/api/users/${id}`);
        Swal.fire('Supprimé!', 'Utilisateur supprimé avec succès.', 'success');
        fetchUtilisateurs(); // Recharger la liste
      } catch (error) {
        console.error('Erreur suppression :', error);
        Swal.fire('Erreur', "La suppression a échoué.", 'error');
      }
    }
  };

  const filtered = utilisateurs.filter(u =>
    `${u.nom} ${u.prenom} ${u.email} ${u.role}`.toLowerCase().includes(search.toLowerCase())
  );

  const formateurs = filtered.filter(u => u.role === 'formateur');
  const admins = filtered.filter(u => u.role === 'admin');

  const renderTable = (title, users, color) => (
    <>
      <h4 className="mt-4">{title}</h4>
      <table className="table table-bordered table-hover">
        <thead className={color}>
          <tr>
            <th>Matricule</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>image</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          {users.length > 0 ? (
            users.map(u => (
              <tr key={u.id}>
                <td>{u.matricule}</td>
                <td>{u.name}</td>
                <td>{u.prename}</td>
                <td>{u.email}</td>
                <td><img src={u.image ? `http://127.0.0.1:8000/storage/${u.image}` : "https://www.gravatar.com/avatar?d=mp"} 
                      className="img-thumbnail" 
                      width="90" 
                      alt="Image de profil"/> 
                  </td>
                <td>
  
                  <Link to={`/Admin/ShowUser/${u.id}`} className="btn btn-info me-1">
                        <i className="bi bi-eye"></i>
                    </Link>
                   <Link to={`/Admin/EditUsers/${u.id}`} className="btn btn-warning me-1">
                        <i className="bi bi-pencil-square"></i>
                    </Link>
                  <button className="btn btn-danger " onClick={() => handleDelete(u)}>
                    <i className="bi bi-trash"></i>
                  </button>
                  
                </td>
              </tr>
            ))
          ) : (
            <tr>
              <td colSpan="5" className="text-center text-muted">Aucun utilisateur trouvé</td>
            </tr>
          )}
        </tbody>
      </table>
    </>
  );

  return (
    <div className="container mt-4">
      <h2 className="mb-3">Gestion des Utilisateurs</h2>

      <Link to="/admin/AddUsers" className="btn btn-primary">
        <i className="fa-solid fa-plus"></i> Ajouter un utilisateur
      </Link>
      <br /><br />

      <input
        type="text"
        className="form-control mb-4"
        placeholder="Rechercher par nom, prénom, email ou rôle..."
        value={search}
        onChange={(e) => setSearch(e.target.value)}
      />

      {renderTable("👨‍💼 Administrateurs", admins, "table-dark")}
      {renderTable("📚 Formateurs", formateurs, "table-secondary")}
    </div>
  );
};

export default ListUsers;
