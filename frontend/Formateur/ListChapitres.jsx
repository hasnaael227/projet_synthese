import React, { useEffect, useState } from "react";
import axios from "axios";
import { Table, Container, Alert, Button } from "react-bootstrap";
import { Link } from "react-router-dom";
import Swal from "sweetalert2";

const ListChapitres = () => {
  const [chapitres, setChapitres] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState("");

  useEffect(() => {
    fetchChapitres();
  }, []);

  const fetchChapitres = async () => {
    try {
      setLoading(true);
      const response = await axios.get("http://localhost:8000/api/chapitres");
      setChapitres(response.data);
      setError("");
    } catch (err) {
      console.error(err);
      setError("Erreur lors du chargement des chapitres.");
    } finally {
      setLoading(false);
    }
  };

  const handleDelete = async (chapitre) => {
    const result = await Swal.fire({
      title: `Supprimer le chapitre "${chapitre.titre}" ?`,
      text: "Cette action est irréversible !",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Oui, supprimer",
      cancelButtonText: "Annuler",
    });

    if (!result.isConfirmed) return;

    try {
      await axios.delete(`http://localhost:8000/api/chapitres/${chapitre.id}`);
      Swal.fire("Supprimé !", "Le chapitre a été supprimé.", "success");
      fetchChapitres();
    } catch (err) {
      console.error(err);
      Swal.fire("Erreur", "Erreur lors de la suppression du chapitre.", "error");
    }
  };

  return (
    <Container className="mt-5">
 <h2 className="mb-4">Liste des Chapitres</h2>
      <Link to="/Formateur/AddChapitre" className="btn btn-primary mb-3">
        <i className="fa-solid fa-plus"></i> + Ajouter une Catégorie
      </Link>
      {error && <Alert variant="danger">{error}</Alert>}

      {loading ? (
        <p className="text-center">Chargement...</p>
      ) : chapitres.length > 0 ? (
        <Table striped bordered hover responsive className="shadow-sm">
          <thead className="table-primary text-center">
            <tr>
             
              <th>Titre</th>
              <th>Catégorie</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            {chapitres.map((chapitre) => (
              <tr key={chapitre.id}>
                <td>{chapitre.titre}</td>
                <td>{chapitre.category?.name || "Non défini"}</td>
                <td className="text-center">
                  <Link
                    to={`/Formateur/ShowChapitre/${chapitre.id}`} className="btn btn-info btn-sm me-1" ><i className="bi bi-eye"></i>
                   </Link>
                   
                  <Link to={`/Formateur/EditChapitre/${chapitre.id}`}className="btn btn-warning btn-sm me-1" >
                    <i className="bi bi-pencil-square"></i>
                  </Link>
                  <Button
                    variant="danger"
                    size="sm"
                    onClick={() => handleDelete(chapitre)}
                  >
                    <i className="bi bi-trash"></i>
                  </Button>
                </td>
              </tr>
            ))}
          </tbody>
        </Table>
      ) : (
        <p className="text-center">Aucun chapitre disponible.</p>
      )}
    </Container>
  );
};

export default ListChapitres;
