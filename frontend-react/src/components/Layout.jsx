import { Link, useNavigate } from 'react-router-dom';
import { useAuth } from '../contexts/AuthContext';

const Layout = ({ children }) => {
  const { user, logout } = useAuth();
  const navigate = useNavigate();

  const handleLogout = async () => {
    await logout();
    navigate('/login');
  };

  return (
    <div className="min-h-screen bg-gray-100">
      <nav className="bg-indigo-600 text-white shadow-lg">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="flex justify-between h-16">
            <div className="flex items-center">
              <Link to="/dashboard" className="text-2xl font-bold">
                IndiGO
              </Link>
              <div className="ml-10 flex space-x-4">
                <Link
                  to="/products"
                  className="hover:bg-indigo-700 px-3 py-2 rounded-md"
                >
                  Productos
                </Link>
                <Link
                  to="/sales"
                  className="hover:bg-indigo-700 px-3 py-2 rounded-md"
                >
                  Ventas
                </Link>
                <Link
                  to="/sales/report"
                  className="hover:bg-indigo-700 px-3 py-2 rounded-md"
                >
                  Reportes
                </Link>
              </div>
            </div>
            <div className="flex items-center space-x-4">
              <span className="text-sm">Hola, {user?.name}</span>
              <button
                onClick={handleLogout}
                className="bg-indigo-700 hover:bg-indigo-800 px-4 py-2 rounded-md"
              >
                Cerrar Sesión
              </button>
            </div>
          </div>
        </div>
      </nav>

      <main className="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        {children}
      </main>
    </div>
  );
};

export default Layout;
