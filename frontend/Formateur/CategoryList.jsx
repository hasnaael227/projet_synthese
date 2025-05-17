import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { Button } from 'react-bootstrap';
import { Link } from "react-router-dom";
import Swal from 'sweetalert2';

const CategoryList = () => {
  const [categories, setCategories] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    fetchCategories();
  }, []);

  const fetchCategories = async () => {
    try {
      setLoading(true);
      const response = await axios.get('http://localhost:8000/api/categories');
      setCategories(response.data);
    } catch (error) {
      console.error('Erreur lors du chargement des catégories :', error);
    } finally {
      setLoading(false);
    }
  };

 const handleDelete = async (category) => {
  const confirmResult = await Swal.fire({
    title: `Supprimer ${category.name} ?`,
    text: "Cette action est irréversible !",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Oui, supprimer',
    cancelButtonText: 'Annuler'
  });

  if (!confirmResult.isConfirmed) return;

  try {
    await axios.delete(`http://localhost:8000/api/categories/${category.id}`); // <-- ici category.id
    Swal.fire('Supprimé !', 'La catégorie a été supprimée.', 'success');
    fetchCategories();
  } catch (error) {
    console.error('Erreur lors de la suppression :', error);
    Swal.fire('Erreur', 'Erreur lors de la suppression de la catégorie.', 'error');
  }
};


  return (
    <div className="container mt-5">
      <h2 className="mb-4">Liste des Catégories</h2>
      <Link to="/Formateur/AddCategory" className="btn btn-primary mb-3">
        <i className="fa-solid fa-plus"></i> + Ajouter une Catégorie
      </Link>

      {loading ? (
        <p>Chargement...</p>
      ) : (
        <table className="table table-bordered table-striped">
          <thead className="table-dark">
            <tr>
             
              <th>Nom</th>
              <th>Description</th>
              <th>Prix</th>
              <th>Image</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            {categories.length > 0 ? (
              categories.map(category => (
                <tr key={category.id}>
                  <td>{category.name}</td>
                  <td>{category.description || '-'}</td>
                  <td>{category.prix != null && !isNaN(category.prix) ? Number(category.prix).toFixed(2) + ' €' : 'N/A'}</td>
                  <td>
                    {category.image ? (
                      <img 
                        src={`http://localhost:8000/storage/${category.image}`} 
                        alt={category.name} 
                        style={{ width: '80px', height: 'auto', borderRadius: '5px' }} 
                      />
                    ) : (
                      <span>Aucune image</span>
                    )}
                  </td>
                  <td>
                    <Link  to={`/Formateur/ShowCategory/${category.id}`} className="btn btn-info me-1">
                       <i className="bi bi-eye"></i>
                    </Link>
                     <Link to={`/Formateur/EditCategory/${category.id}`}  className="btn btn-warning me-1">
                        <i className="bi bi-pencil-square"></i>
                    </Link>
                    <Button variant="danger"  className="btn btn-danger "  onClick={() => handleDelete(category)}>  
                      <i className="bi bi-trash"></i>
                      </Button>
                  </td>
                </tr>
              ))
            ) : (
              <tr>
                <td colSpan="6" className="text-center">Aucune catégorie trouvée.</td>
              </tr>
            )}
          </tbody>
        </table>
      )}
    </div>
  );
};

export default CategoryList;
