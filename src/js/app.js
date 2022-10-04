import ReactDOM from 'react-dom/client';
import Settings from './settings/Settings';
import { SettingsContextProvider } from './contexts/SettingsContext';

(function() {
  console.log('-- App started --');
  if (typeof window !== "undefined") {
    document.querySelectorAll('div[data-react_project]').forEach((elem) => {
      const initSettings = JSON.parse(elem.dataset.react_project);
      const container = ReactDOM.createRoot(elem);
      container.render(
        <SettingsContextProvider initSettings={initSettings}>
          <Settings />
        </SettingsContextProvider>
      );
    });
  }
})();