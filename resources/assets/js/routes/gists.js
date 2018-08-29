import GistList from '../components/Gist/GistList';
import GistCreate from '../components/Gist/GistCreate';

const GistsRoutes = [
    {
        path: '/',
        name: 'gists.list',
        component: GistList
    },
    {
        path: 'create',
        name: 'gists.create',
        component: GistCreate
    }
];

export default GistsRoutes;