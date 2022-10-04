export default function DisplayTopLeft({ settings }) {
  return <div style={{
      position: 'fixed',
      top: '20px',
      left: '20px',
      lineHeight: 1,
      padding: '20px',
      color: '#fff',
      background: settings.backgroundColour,
      textAlign: 'center',
      fontSize: 14,
      zIndex: 999}}>
    {settings.displayText}
  </div>
}