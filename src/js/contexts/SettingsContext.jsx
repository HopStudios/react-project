import { useEffect, useMemo, useReducer, useState, createContext } from 'react';
// import ReactDOMServer from 'react-dom/server';
import DisplayTopLeft from '../formats/DisplayTopLeft';
import DisplayTopRight from '../formats/DisplayTopRight';
import DisplayBottomLeft from '../formats/DisplayBottomLeft';
import DisplayBottomRight from '../formats/DisplayBottomRight';

const SettingsContext = createContext();

let displayObject = '';

const reducer = (settings, action) => {
  let currentSettings = {...settings};
  let value = action.payload.value;

  switch (action.type) {
    case 'update':
      switch (action.payload.setting) {
        case 'code':
          currentSettings.code = value;
          break;
        case 'displayText':
          currentSettings.displayText = value;
          break;
        case 'backgroundColour':
          currentSettings.backgroundColour = value;
          break;
        case 'displayFormat':
          currentSettings.displayFormat = value;
          break;
        case 'country':
          currentSettings.country = value;
          break;
      }
      break;
    default:
      break;
  }
  return currentSettings;
}

export function SettingsContextProvider ({ initSettings, children }) {
  const [isLoaded, setLoaded] = useState(false);
  const [attachCM, setAttachCM] = useState(null);
  const [settings, dispatch] = useReducer(reducer, initSettings);

  const handleChange = (setting, value) => {
    dispatch({ type: 'update', payload: { setting, value }});
  }

  const display = useMemo(() => {
    if (isLoaded) {
      switch(settings.displayFormat) {
        case 'top_left':
          displayObject = <DisplayTopLeft settings={settings} />
          break;
        case 'top_right':
          displayObject = <DisplayTopRight settings={settings} />
          break;
        case 'bottom_left':
          displayObject = <DisplayBottomLeft settings={settings}  />
          break;
        case 'bottom_right':
          displayObject = <DisplayBottomRight settings={settings}  />
          break;
        default:
          break;
      }

      return displayObject;
    }
  }, [isLoaded, settings]);

  useEffect(() => {
    if (! isLoaded) {
      console.log('-- App loaded --');
      document.addEventListener('submitHook', () => {
        console.log('-- Submit hook triggered --');
      }, false);
      setLoaded(true);
    }
  }, [isLoaded]);

  useEffect(() => {
    if (attachCM) {
      if (document.getElementById('code_block') && ! document.getElementById('code_block').hasAttribute('data-loaded')) {
        document.getElementById('code_block').setAttribute('data-loaded', true);
        document.getElementById('code_block').addEventListener('input', (e) => {
          dispatch({ type: 'update', payload: { setting: 'code', value: e.currentTarget.value } });
        });
        console.log('-- Attaching CodeMirror input event --');
      }
      setAttachCM(false);
    }
  }, [attachCM]);

  return (
    <SettingsContext.Provider value={{ isLoaded, settings, display, handleChange, setAttachCM }}>{children}</SettingsContext.Provider>
  );
}

export default SettingsContext;