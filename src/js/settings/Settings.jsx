import { useContext} from 'react';
import Countries from './Countries';
import DisplayFormat from './DisplayFormat';
import SettingsContext from '../contexts/SettingsContext';
import EEAlert from '../components/EEAlert';

export default function Settings() {
  const { isLoaded, display } = useContext(SettingsContext);

  if (! isLoaded) {
    return <EEAlert type="loading" message="Loading..." />
  } else {
    return <>
      <div className="react_project">
        {display}
      </div>
      <DisplayFormat />
      <Countries />
    </>
  }
}