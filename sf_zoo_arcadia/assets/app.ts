import './bootstrap.js';
import { registerReactControllerComponents } from '@symfony/ux-react';
registerReactControllerComponents(require.context('./react/controllers', true, /\.(j|t)sx?$/));

import './styles/app.css';

import Header from '../assets/react/controllers/components/header'