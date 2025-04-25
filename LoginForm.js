// LoginForm.js
import React, { useState } from 'react';

function LoginForm() {
  const [formData, setFormData] = useState({ email: '', password: '' });
  const [message, setMessage] = useState('');

  const handleChange = (e) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      const response = await fetch('http://localhost/studentfoods-api/login.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams(formData).toString()
      });
      const text = await response.text();
      setMessage(text);
    } catch (error) {
      setMessage('❌ Σφάλμα σύνδεσης με τον διακομιστή.');
    }
  };

  return (
    <div className="p-4 max-w-md mx-auto">
      <h2 className="text-xl font-bold mb-4">Σύνδεση</h2>
      <form onSubmit={handleSubmit} className="flex flex-col gap-2">
        <input
          type="email"
          name="email"
          placeholder="Email"
          className="border p-2 rounded"
          value={formData.email}
          onChange={handleChange}
          required
        />
        <input
          type="password"
          name="password"
          placeholder="Κωδικός"
          className="border p-2 rounded"
          value={formData.password}
          onChange={handleChange}
          required
        />
        <button type="submit" className="bg-blue-500 text-white rounded p-2 hover:bg-blue-600">
          Είσοδος
        </button>
      </form>
      {message && <p className="mt-4 text-center">{message}</p>}
    </div>
  );
}

export default LoginForm;