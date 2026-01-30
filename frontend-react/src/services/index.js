import api from './api';

export const authService = {
  async login(credentials) {
    const response = await api.post('/auth/login', credentials);
    return response.data;
  },

  async register(userData) {
    const response = await api.post('/auth/register', userData);
    return response.data;
  },

  async logout() {
    const response = await api.post('/auth/logout');
    return response.data;
  },

  async getUser() {
    const response = await api.get('/auth/user');
    return response.data;
  },
};

export const productService = {
  async getAll(page = 1) {
    const response = await api.get(`/products?page=${page}`);
    return response.data;
  },

  async getById(id) {
    const response = await api.get(`/products/${id}`);
    return response.data;
  },

  async create(productData) {
    const formData = new FormData();
    Object.keys(productData).forEach(key => {
      formData.append(key, productData[key]);
    });
    
    const response = await api.post('/products', formData, {
      headers: { 'Content-Type': 'multipart/form-data' },
    });
    return response.data;
  },

  async update(id, productData) {
    const formData = new FormData();
    Object.keys(productData).forEach(key => {
      if (productData[key] !== null && productData[key] !== undefined) {
        formData.append(key, productData[key]);
      }
    });
    formData.append('_method', 'PUT');
    
    const response = await api.post(`/products/${id}`, formData, {
      headers: { 'Content-Type': 'multipart/form-data' },
    });
    return response.data;
  },

  async delete(id) {
    const response = await api.delete(`/products/${id}`);
    return response.data;
  },
};

export const categoryService = {
  async getAll() {
    const response = await api.get('/categories');
    return response.data;
  },
};

export const saleService = {
  async getAll(page = 1) {
    const response = await api.get(`/sales?page=${page}`);
    return response.data;
  },

  async getById(id) {
    const response = await api.get(`/sales/${id}`);
    return response.data;
  },

  async create(saleData) {
    const response = await api.post('/sales', saleData);
    return response.data;
  },

  async getReport(startDate, endDate) {
    const response = await api.get('/sales/report/by-date', {
      params: { start_date: startDate, end_date: endDate },
    });
    return response.data;
  },
};
