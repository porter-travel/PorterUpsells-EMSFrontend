import React from 'react';

export default function Header() {
  return (
    <header className="flex items-center justify-between bg-white border-b px-4 py-2">
      <div className="flex items-center">
        <a href="/" className="text-xl font-bold">EMS</a>
      </div>
      <div>
        <select className="border rounded px-3 py-1">
          <option>My Property</option>
          <option>Add Property</option>
        </select>
      </div>
    </header>
  );
}
