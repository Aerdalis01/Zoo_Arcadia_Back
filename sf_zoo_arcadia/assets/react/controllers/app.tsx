import './scss/app.scss';

import React from 'react';
import Header  from './components/header';
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';

// import HomePage from '../pages/HomePage';
// import AboutPage from './pages/AboutPage';
// import ContactPage from './pages/ContactPage';
// import ServicesPage from './pages/ServicesPage';

// const App = () => {
//     return (
//         <Router>
//             <Routes>
//                 <Route path="/" element={<HomePage />} />
//                 <Route path="/about" element={<AboutPage />} />
//                 <Route path="/contact" element={<ContactPage />} />
//                 <Route path="/services" element={<ServicesPage />} />
//             </Routes>
//         </Router>
//     );
// };

// ReactDOM.render(<App />, document.getElementById('root'));







const App: React.FC = () => {
  return (
      <div>
          <Header />
      </div>
  );
};

