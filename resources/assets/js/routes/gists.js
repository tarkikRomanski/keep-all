import GistCreate from '../components/Gist/GistCreate';
import Repo from '../components/Repo/Repository';

const GistsRoutes = [
    {
        path: '/',
        name: 'gists.list',
        component: Repo
    },
    {
        path: 'create',
        name: 'gists.create',
        component: GistCreate
    },
    {
        path: 'folder/:folder',
        name: 'gists.folder',
        props: route => ({ folder: parseInt(route.params.folder) }),
        component: Repo
    }
];

export default GistsRoutes;