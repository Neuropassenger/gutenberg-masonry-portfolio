import {useEffect, useState} from 'react';
import apiFetch from '@wordpress/api-fetch';
import Masonry from 'react-masonry-css';

import MasonryPost from './MasonryPost';
import MasonryFilter from './MasonryFilter';

const  MasonryPortfolio = (props) => {
    const [posts, setPosts] = useState({list: [], isFetching: false});

    async function fetchData() {
        try {
			setPosts({list: posts.list, isFetching: true});
			/* const apiPath = 'wp/v2/reference?_fields=id,title,content,categories,exclusive,link,thumbnail_url&search='
				+ searchQuery.text + '&reference_category=' + categoriesForFetch
				+ '&filter[orderby]=rand' + exclusiveMetaForFetch; */
            //const apiPath = 'wp/v2/bws_portfolio_post?filter[orderby]=rand&_embed';
            const apiPath = 'wp/v2/bws_portfolio_post?_embed';

			const response = await apiFetch({
				path: apiPath
			});

			setPosts({list: response, isFetching: false});
		} catch (error) {
			console.log(error);
			setPosts({list: posts.list, isFetching: false});
		}
    }

    useEffect(async() => {
        await fetchData();
    }, []);

    console.log({posts});

    const breakpointColumnsObj = {
        default: 3, // Количество столбцов по умолчанию
        1100: 2,    // При ширине экрана 1100px будут 2 столбца
        700: 1      // При ширине экрана 700px будет 1 столбец
    };

    return (
        <>
        <MasonryFilter />
        <Masonry
            breakpointCols={breakpointColumnsObj}
            className="bws_gutenberg-masonry-portfolio-grid"
            columnClassName="bws_gutenberg-masonry-portfolio-grid-column"
        >
            {posts.list.map((post, index) => (
                <MasonryPost key={index} postData={post} />
            ))}
        </Masonry>
        </>
    );
}

export default MasonryPortfolio;