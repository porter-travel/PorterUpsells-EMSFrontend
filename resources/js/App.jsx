import React from 'react';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import Header from './components/Header';
import Sidebar from './components/Sidebar';
import Products from './pages/Products';
import Orders from './pages/Orders';
import Guests from './pages/Guests';
import Performance from './pages/Performance';
import Calendar from './pages/Calendar';
import Fulfilment from './pages/Fulfilment';
import Branding from './pages/Branding';
import Settings from './pages/Settings';
import InfoPages from './pages/InfoPages';

export default function App() {
  const isAuthenticated = true;
  return (
    <Router>
      <div className="flex flex-col h-screen">
        <Header />
        <div className="flex flex-1">
          {isAuthenticated && <Sidebar />}
          <main className="flex-1 flex flex-col p-4 overflow-y-auto layout-content-container">
            <Routes>
              <Route path="/products" element={<Products />} />
              <Route path="/orders" element={<Orders />} />
              <Route path="/guests" element={<Guests />} />
              <Route path="/performance" element={<Performance />} />
              <Route path="/calendar" element={<Calendar />} />
              <Route path="/fulfilment" element={<Fulfilment />} />
              <Route path="/branding" element={<Branding />} />
              <Route path="/settings" element={<Settings />} />
              <Route path="/info-pages" element={<InfoPages />} />
            </Routes>
          </main>
        </div>
      </div>
    </Router>
  );
}
