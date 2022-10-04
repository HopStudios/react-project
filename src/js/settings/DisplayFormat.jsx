import { useContext, useEffect } from 'react';
import SettingsContext from '../contexts/SettingsContext';
import StylesEditor from './styles/Editor';

export default function DisplayFormat() {
  const { settings, handleChange, setAttachCM, } = useContext(SettingsContext);

  useEffect(() => {
    setAttachCM(true);
  }, [setAttachCM]);

  return <>
    <fieldset id="fieldset-display_format" className="fieldset-required">
      <div className="field-instruct">
        <label htmlFor="display_format">Display Format</label>
      </div>
      <div className="field-control">
        <div className="fields-select display_format" data-input-value="display_format">
          <div className="field-inputs">
            {settings.displayFormatOptions.map((r, index) => {
              return (<label className="checkbox-label" key={index}>
                <input
                  type="radio"
                  name="display_format"
                  value={r.value}
                  checked={r.value === settings.displayFormat}
                  onChange={e => handleChange('displayFormat', e.target.value)}
                />
                <div className="checkbox-label__text">
                  {r.label}
                </div>
              </label>)
            })}
          </div>
        </div>
      </div>
    </fieldset>
    <StylesEditor  />
    <textarea
      id="code_block"
      name="code_block"
      rows="9"
      value={settings.code}
      onChange={e => handleChange('code', e.target.value)} />
  </>
}