import React from 'react';
import { Link } from 'react-router-dom';
import {
  CubeIcon,
  ShoppingCartIcon,
  UserGroupIcon,
  ChartBarIcon,
  CalendarIcon,
  TruckIcon,
  PaintBrushIcon,
  Cog6ToothIcon,
  InformationCircleIcon,
} from '@heroicons/react/24/outline';

const navigation = [
  { name: 'Products', href: '/products', icon: CubeIcon },
  { name: 'Orders', href: '/orders', icon: ShoppingCartIcon },
  { name: 'Guests', href: '/guests', icon: UserGroupIcon },
  { name: 'Performance', href: '/performance', icon: ChartBarIcon },
  { name: 'Calendar', href: '/calendar', icon: CalendarIcon },
  { name: 'Fulfilment', href: '/fulfilment', icon: TruckIcon },
  { name: 'Branding', href: '/branding', icon: PaintBrushIcon },
  { name: 'Settings', href: '/settings', icon: Cog6ToothIcon },
  { name: 'Info Pages (Coming Soon)', href: '/info-pages', icon: InformationCircleIcon },
];

export default function Sidebar() {
  return (
    <aside className="w-64 border-r bg-white">
      <nav className="p-4 space-y-1">
        {navigation.map((item) => (
          <Link
            key={item.name}
            to={item.href}
            className="flex items-center px-2 py-2 text-gray-700 hover:bg-gray-100 rounded"
          >
            <item.icon className="w-5 h-5 mr-3" />
            <span className="text-sm font-medium">{item.name}</span>
          </Link>
        ))}
      </nav>
    </aside>
  );
}
