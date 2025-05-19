import React from 'react';
import { Outlet } from 'react-router-dom';
import AdminNavbar from '../layouts/AdminNavbar';
import Footer from '../components/Footer';
const MainLayoute = () => {
  return (
    <>
      <AdminNavbar />
      <main className="container mt-4">
        <Outlet />
      </main>
     
    </>
  );
};

export default MainLayoute;
