import i18n from '@/lang';

const title = process.env.MIX_APP_TITLE;

export default function getPageTitle(key) {
  const hasKey = i18n.te(`${key}`);
  if (hasKey) {
    const pageName = i18n.t(`${key}`);
    return `${pageName} - ${title}`;
  }
  return `${title}`;
}
