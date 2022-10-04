export default function DisplayTopRight({ settings }) {
  return <div style={{
      position: 'fixed',
      top: '20px',
      right: '20px',
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