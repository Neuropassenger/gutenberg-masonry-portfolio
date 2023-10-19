import {useEffect, useState} from 'react';
import apiFetch from '@wordpress/api-fetch';

const  MasonryPortfolio = (props) => {
    const [posts, setPosts] = useState({list: [], isFetching: false});

    async function fetchData() {
        try {
			setPosts({list: posts.list, isFetching: true});
			/* const apiPath = 'wp/v2/reference?_fields=id,title,content,categories,exclusive,link,thumbnail_url&search='
				+ searchQuery.text + '&reference_category=' + categoriesForFetch
				+ '&filter[orderby]=rand' + exclusiveMetaForFetch; */
            const apiPath = 'wp/v2/bws_portfolio_post?filter[orderby]=rand';

			const response = await apiFetch({
				path: apiPath
			});

			setPosts({list: response.sort(() => Math.random() - 0.5), isFetching: false});
		} catch (error) {
			console.log(error);
			setPosts({list: posts.list, isFetching: false});
		}
    }

    useEffect(async() => {
        await fetchData();
    }, []);

    console.log({posts});
    return 'hello';
}

export default MasonryPortfolio;