import { useContext } from 'react';
import Select from 'react-select'
import SettingsContext from '../contexts/SettingsContext';

export default function Countries() {
  const { settings, handleChange } = useContext(SettingsContext);

  return <fieldset id="fieldset-countries" className="fieldset-required">
    <div className="field-instruct ">
      <label htmlFor="countries">Countries</label>
    </div>
    <div className="field-control">
      <Select
        id="country"
        name="country"
        className="country"
        selected={settings.country}
        onChange={option => handleChange('country', option.value)}
        options={settings.countryOptions}
      />
    </div>
  </fieldset>
}