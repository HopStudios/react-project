export default function EEAlert({type, message}) {
    let noticeClass = 'app-notice app-notice--inline app-notice---' + type;
    return <div className={noticeClass}><div className="app-notice__content">{message}</div></div>
}