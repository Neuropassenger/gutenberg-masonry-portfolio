import he from 'he';

const MasonryPost = (props) => {
    return (
        <div className="bws_masonry-post">
            <a href={props.postData.link}>
                <h2>{he.decode(props.postData.title.rendered)}</h2>
                <img 
                    loading="lazy" 
                    src={props.postData._embedded["wp:featuredmedia"][0].source_url} 
                    alt={he.decode(props.postData.title.rendered)} 
                />
            </a>
        </div>
    );
}

export default MasonryPost;