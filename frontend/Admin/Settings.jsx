import React, { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import 'bootstrap/dist/css/bootstrap.min.css';
import Swal from 'sweetalert2';
import withReactContent from 'sweetalert2-react-content';

const MySwal = withReactContent(Swal);

const Settings = () => {
  const navigate = useNavigate();
  const user = JSON.parse(localStorage.getItem('user'));
  const userId = user ? user.id : null;

  const [username, setUsername] = useState('');
  const [prename, setPrename] = useState('');
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [confirmPassword, setConfirmPassword] = useState('');
  const [loading, setLoading] = useState(false);
  const [apiError, setApiError] = useState(null);
  const [apiSuccess, setApiSuccess] = useState(null);
  const [image, setimage] = useState(null);
  const [previewUrl, setPreviewUrl] = useState(null);

  useEffect(() => {
    if (!userId) {
      MySwal.fire({
        icon: 'warning',
        title: 'Utilisateur non connecté',
        text: 'Vous devez vous connecter pour accéder à cette page.',
      }).then(() => navigate('/login'));
    }
  }, [userId, navigate]);

  useEffect(() => {
    if (!userId) return;

    fetch(`http://127.0.0.1:8000/api/users/${userId}/profile`, {
      headers: {
        Accept: 'application/json',
        Authorization: `Bearer ${user.token}` // si Sanctum ou API token
      }
    })
      .then(res => {
        if (!res.ok) throw new Error('Erreur de chargement');
        return res.json();
      })
      .then(data => {
        setUsername(data.name || '');
        setPrename(data.prename || '');
        setEmail(data.email || '');
        if (data.image) {
          setPreviewUrl(`http://127.0.0.1:8000/storage/${data.image}`);
        }
      })
      .catch(err => setApiError(err.message));
  }, [userId]);

  const handleImageChange = (e) => {
    const file = e.target.files[0];
    if (file) {
      setimage(file);
      setPreviewUrl(URL.createObjectURL(file));
    }
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setApiError(null);
    setApiSuccess(null);

    if (password && password !== confirmPassword) {
      setApiError("Les mots de passe ne correspondent pas");
      return;
    }

    const confirm = await MySwal.fire({
      title: 'Confirmer la mise à jour ?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Oui',
      cancelButtonText: 'Annuler',
    });

    if (!confirm.isConfirmed) return;

    setLoading(true);

    const formData = new FormData();
    formData.append('_method', 'PUT'); // car Laravel utilise POST avec override
    formData.append('name', username);
    formData.append('prename', prename);
    formData.append('email', email);

    if (password) {
      formData.append('password', password);
      formData.append('password_confirmation', confirmPassword);
    }

    if (image && typeof image !== 'string') {
      formData.append('image', image);
    }

    try {
      const response = await fetch(`http://127.0.0.1:8000/api/users/${userId}/profile`, {
        method: 'POST',
        headers: {
          Accept: 'application/json',
          Authorization: `Bearer ${user.token}` // si token auth utilisé
        },
        body: formData
      });

      const data = await response.json();

      if (response.ok) {
        setApiSuccess(data.message || 'Profil mis à jour');
        setPassword('');
        setConfirmPassword('');
      } else {
        setApiError(data.message || 'Erreur');
      }
    } catch (err) {
      setApiError('Erreur réseau');
    } finally {
      setLoading(false);
    }
  };

  if (!userId) return null;

  return (
    <div className="container py-5">
      <div className="row justify-content-center">
        <div className="col-md-8 col-lg-6">
          <div className="card shadow-lg p-4">
            <h3 className="text-center mb-4">Paramètres du Profil</h3>

            {apiError && <div className="alert alert-danger">{apiError}</div>}
            {apiSuccess && <div className="alert alert-success">{apiSuccess}</div>}
            {loading && <div className="alert alert-info">Chargement...</div>}

            <form onSubmit={handleSubmit} encType="multipart/form-data">
              <div className="text-center mb-4">
                <img
                  src={previewUrl || 'https://via.placeholder.com/100'}
                  alt="Aperçu"
                  className="rounded-circle shadow"
                  width="100"
                  height="100"
                  style={{ objectFit: 'cover' }}
                />
                <input
                  type="file"
                  accept="image/*"
                  onChange={handleImageChange}
                  className="form-control mt-2"
                />
              </div>

              <div className="mb-3">
                <label className="form-label">Nom</label>
                <input type="text" className="form-control" value={username} onChange={e => setUsername(e.target.value)} required />
              </div>

              <div className="mb-3">
                <label className="form-label">Prénom</label>
                <input type="text" className="form-control" value={prename} onChange={e => setPrename(e.target.value)} required />
              </div>

              <div className="mb-3">
                <label className="form-label">Email</label>
                <input type="email" className="form-control" value={email} onChange={e => setEmail(e.target.value)} required />
              </div>

              <div className="mb-3">
                <label className="form-label">Mot de passe</label>
                <input type="password" className="form-control" value={password} onChange={e => setPassword(e.target.value)} placeholder="Laisser vide si inchangé" />
              </div>

              <div className="mb-3">
                <label className="form-label">Confirmer le mot de passe</label>
                <input type="password" className="form-control" value={confirmPassword} onChange={e => setConfirmPassword(e.target.value)} />
              </div>

              <button type="submit" className="btn btn-primary w-100" disabled={loading}>
                {loading ? 'Sauvegarde...' : 'Mettre à jour'}
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Settings;
