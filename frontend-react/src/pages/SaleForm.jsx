import { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import { productService, saleService } from '../services';
import { useAuth } from '../contexts/AuthContext';

const SaleForm = () => {
  const { user } = useAuth();
  const navigate = useNavigate();
  const [products, setProducts] = useState([]);
  const [items, setItems] = useState([]);
  const [selectedProduct, setSelectedProduct] = useState('');
  const [quantity, setQuantity] = useState(1);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState('');

  useEffect(() => {
    loadProducts();
  }, []);

  const loadProducts = async () => {
    try {
      const response = await productService.getAll();
      setProducts(response.data);
    } catch (err) {
      setError('Error al cargar productos');
    }
  };

  const addItem = () => {
    if (!selectedProduct || quantity < 1) return;

    const product = products.find((p) => p.id === parseInt(selectedProduct));
    if (!product) return;

    const existingItem = items.find((i) => i.product_id === product.id);
    if (existingItem) {
      setItems(
        items.map((i) =>
          i.product_id === product.id
            ? { ...i, quantity: i.quantity + quantity }
            : i
        )
      );
    } else {
      setItems([...items, { product_id: product.id, product, quantity }]);
    }

    setSelectedProduct('');
    setQuantity(1);
  };

  const removeItem = (productId) => {
    setItems(items.filter((i) => i.product_id !== productId));
  };

  const calculateTotal = () => {
    return items.reduce((sum, item) => sum + item.product.price * item.quantity, 0);
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    if (items.length === 0) {
      setError('Debes agregar al menos un producto');
      return;
    }

    setLoading(true);
    setError('');

    try {
      await saleService.create({
        user_id: user.id,
        items: items.map((i) => ({
          product_id: i.product_id,
          quantity: i.quantity,
        })),
      });
      navigate('/sales');
    } catch (err) {
      setError(err.response?.data?.error || 'Error al registrar la venta');
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="max-w-4xl mx-auto px-4 sm:px-0">
      <h1 className="text-3xl font-bold text-gray-900 mb-6">Nueva Venta</h1>

      {error && (
        <div className="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
          {error}
        </div>
      )}

      <div className="bg-white shadow sm:rounded-lg p-6 mb-6">
        <h2 className="text-lg font-medium text-gray-900 mb-4">Agregar Productos</h2>
        <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div className="md:col-span-2">
            <select
              className="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
              value={selectedProduct}
              onChange={(e) => setSelectedProduct(e.target.value)}
            >
              <option value="">Seleccionar producto</option>
              {products.map((product) => (
                <option key={product.id} value={product.id}>
                  {product.name} - ${product.price} (Stock: {product.stock})
                </option>
              ))}
            </select>
          </div>
          <div className="flex gap-2">
            <input
              type="number"
              min="1"
              className="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
              value={quantity}
              onChange={(e) => setQuantity(parseInt(e.target.value) || 1)}
            />
            <button
              type="button"
              onClick={addItem}
              className="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700"
            >
              Agregar
            </button>
          </div>
        </div>
      </div>

      <form onSubmit={handleSubmit}>
        <div className="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
          <div className="px-4 py-5 sm:px-6">
            <h3 className="text-lg leading-6 font-medium text-gray-900">
              Items de la Venta
            </h3>
          </div>
          <div className="border-t border-gray-200">
            {items.length === 0 ? (
              <p className="px-4 py-5 text-gray-500 text-center">
                No hay productos agregados
              </p>
            ) : (
              <table className="min-w-full divide-y divide-gray-200">
                <thead className="bg-gray-50">
                  <tr>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                      Producto
                    </th>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                      Precio
                    </th>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                      Cantidad
                    </th>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                      Subtotal
                    </th>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                      Acción
                    </th>
                  </tr>
                </thead>
                <tbody className="bg-white divide-y divide-gray-200">
                  {items.map((item) => (
                    <tr key={item.product_id}>
                      <td className="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {item.product.name}
                      </td>
                      <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        ${item.product.price}
                      </td>
                      <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {item.quantity}
                      </td>
                      <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        ${(item.product.price * item.quantity).toFixed(2)}
                      </td>
                      <td className="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button
                          type="button"
                          onClick={() => removeItem(item.product_id)}
                          className="text-red-600 hover:text-red-900"
                        >
                          Eliminar
                        </button>
                      </td>
                    </tr>
                  ))}
                </tbody>
              </table>
            )}
          </div>
          <div className="bg-gray-50 px-4 py-4 sm:px-6 border-t border-gray-200">
            <div className="flex justify-end">
              <p className="text-xl font-bold text-gray-900">
                Total: ${calculateTotal().toFixed(2)}
              </p>
            </div>
          </div>
        </div>

        <div className="flex justify-end space-x-3">
          <button
            type="button"
            onClick={() => navigate('/sales')}
            className="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50"
          >
            Cancelar
          </button>
          <button
            type="submit"
            disabled={loading || items.length === 0}
            className="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 disabled:opacity-50"
          >
            {loading ? 'Guardando...' : 'Registrar Venta'}
          </button>
        </div>
      </form>
    </div>
  );
};

export default SaleForm;
