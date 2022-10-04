export default function Input({ type, settings, handleChange }) {
  return <div className="styleEditor-row">
    <label htmlFor={settings.id}>{settings.label}</label>
    <input
      id={settings.id}
      name={settings.name}
      type={type}
      value={settings.value}
      onChange={e => handleChange(settings.styleName, e.target.value)} />
  </div>
}