import { createBrowserRouter } from 'react-router-dom';


// Pages publiques
import MainLayout from '../components/MainLayout';
import HomePage from '../components/HomePage';
import CoursesPage from '../components/CoursesPage';
import Login from '../components/Login';
import Register from '../components/Register';
import NotFound from '../components/NotFound';
import Dashboard from '../components/Dashboard';
import Logout from '../components/Logout';


import MainLayoute from '../components/MainLayoute';
import Admin from '../components/Admin/Admin';
import AdminDashboard from '../components/Admin/AdminDashboard';
import Settings from '../components/Admin/Settings';
import ListUsers from '../components/Admin/ListUsers';
import ListCours from '../components/Admin/ListCours';
import AddUsers from '../components/Admin/AddUsers';
import EditUsers from '../components/Admin/EditUser';
import ShowUser from '../components/Admin/ShowUser';


import FormateurDashboard from '../components/Formateur/FormateurDashboard';
import Etudiants from '../components/Formateur/Etudiants';
import AddCategory from '../components/Formateur/AddCategory';
import ListeCours from '../components/Formateur/ListCours';
import CategoryList from '../components/Formateur/CategoryList';


export const router = createBrowserRouter([
  // Routes publiques
  { path: '/', element: <HomePage /> },
  {
    element: <MainLayout />,
    children: [
      { path: '/cours', element: <CoursesPage /> },
      { path: '/login', element: <Login /> },
      { path: '/register', element: <Register /> },
      { path: '/Dashboard', element: <Dashboard /> },
      { path: '/logout', element: <Logout /> },
    ]
  },
 



 { path: '/Admin', element: <Admin /> },
{
  element: <MainLayoute />,
  children: [
    { path: '/Admin/Settings', element: <Settings /> },
    { path: '/Admin/AdminDashboard', element: <AdminDashboard /> },
    { path: '/Admin/ListUsers', element: <ListUsers /> },
    { path: '/Admin/EditUsers/:id', element: <EditUsers /> },
    { path: '/Admin/AddUsers', element: <AddUsers /> },
    { path: '/Admin/ShowUser/:id', element: <ShowUser /> },
    { path: '/Admin/ListCours', element: <ListCours /> }, 

    { path: '/Formateur/FormateurDashboard', element: <FormateurDashboard /> },
    { path: '/Formateur/Etudiants', element: <Etudiants /> },
    { path: '/Formateur/Cours', element: <ListCours /> }, 
    { path: '/Formateur/CategoryList', element: <CategoryList /> }, 
    { path: '/Formateur/AddCategory', element: <AddCategory /> }, 
  ]
},



  // {
 

  //   element: <PrivateRoute allowedRoles={['admin']} />,
  //   children: [
  //     {
  //       element: <AdminNavbar />,
  //       children: [
  //         { path: '/Admin', element: <Admin /> },
         
  //       ]
  //     }
  //   ]
  // },



  // Page 404
  { path: '*', element: <NotFound /> },
]);
