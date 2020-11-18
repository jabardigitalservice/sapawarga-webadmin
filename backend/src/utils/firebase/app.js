import firebase from 'firebase/app'
import credentials from './credentials'
import 'firebase/remote-config'

export const App = firebase.initializeApp(credentials.config)
