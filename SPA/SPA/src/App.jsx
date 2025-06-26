import './styles/styles.css';

// Importa tus componentes aquí
import SignIn from './pages/SignIn';
import Register from './pages/Register';
import PasswordRecovery from './pages/PasswordRecovery';
import Dashboard from './pages/dashboard';


function App() {
  return (
    <div className="app">
      <Dashboard />
    </div>
  );
}

export default App;
