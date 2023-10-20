import {useEffect, useState} from 'react';
import apiFetch from '@wordpress/api-fetch';
import Masonry from 'react-masonry-css';

import MasonryPost from './MasonryPost';
import MasonryFilter from './MasonryFilter';

const  MasonryPortfolio = (props) => {
    const [posts, setPosts] = useState({list: [], isFetching: false});
    const [categories, setCategories] = useState({list: [], isFetching: false});
    const [selectedCategories, setSelectedCategories] = useState([]);
    const [postsForDisplayCount, setPostsForDisplayCount] = useState(0);

    async function fetchCategories() {
        try {
			setCategories({...categories, isFetching: true});

			const response = await apiFetch({
				path: 'wp/v2/bws_portfolio_cat?_fields=id,name,slug'
			});
			setCategories({list: response, isFetching: false});
		} catch (error) {
			console.log(error);
			setCategories({...categories, isFetching: false});
		}
    }

    async function fetchPosts() {
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
        await fetchCategories();
        await fetchPosts();
    }, []);

    function categoryOnClick(categoryId) {
        // All categories
        if (categoryId == -1) {
            setSelectedCategories([]);
        // Exclude category
        } else if (selectedCategories.includes(categoryId)) {
            const updatedSelectedCategories = selectedCategories.filter((value) => value !== categoryId);
            setSelectedCategories(updatedSelectedCategories);
        // Include category
        } else {
            setSelectedCategories([...selectedCategories, categoryId]);
        }
    }

    console.log({posts}, {categories});

    const breakpointColumnsObj = {
        default: 3, // Количество столбцов по умолчанию
        1100: 2,    // При ширине экрана 1100px будут 2 столбца
        700: 1      // При ширине экрана 700px будет 1 столбец
    };

    return (
        <>
        <MasonryFilter 
            categories={categories} 
            categoryOnClick={categoryOnClick}
            selectedCategories={selectedCategories}
        />
        <Masonry
            breakpointCols={breakpointColumnsObj}
            className="bws_gutenberg-masonry-portfolio-grid"
            columnClassName="bws_gutenberg-masonry-portfolio-grid-column"
        >
            {posts.list.map((post, index) => {
                if (selectedCategories.length == 0 || selectedCategories.every((categoryId) => {
                    return post.bws_portfolio_cat.includes(categoryId)
                })) {
                    return <MasonryPost key={index} postData={post} />;
                }
            })}
        </Masonry>
        </>
    );
}

export default MasonryPortfolio;