import { useContext } from 'react';
import SettingsContext from '../../contexts/SettingsContext';
import Input from './Input';

export default function StylesEditor() {
  const { settings, handleChange } = useContext(SettingsContext);

  const styles = [
    {
      type: 'text',
      settings: {
        id: 'styleEditor__displayText',
        label: 'Display Text',
        name: 'display_text',
        styleName: 'displayText',
        value: settings.displayText,
      },
      handleChange: handleChange
    },
    {
      type: 'color',
      settings: {
        id: 'styleEditor__backgroundColour',
        label: 'Background Colour',
        name: 'background_colour',
        styleName: 'backgroundColour',
        value: settings.backgroundColour,
      },
      handleChange: handleChange
    },
  ];

  return <div className="styleEditor">
    {styles.map((r, index) => {
      switch (r.type) {
        case 'text':
        case 'color':
          return <Input key={index} type={r.type} settings={r.settings} handleChange={handleChange} />
        default:
          return <Input key={index} type="text" settings={r.settings} handleChange={handleChange} />
      }
    })}
  </div>
}