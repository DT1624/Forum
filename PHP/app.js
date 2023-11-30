document.addEventListener("DOMContentLoaded", function () {
    const likedPostIds = [];

    function renderPost(post) {
        const blogPostsContainer = document.getElementById("blog-posts");

        // Create a post container
        const postContainer = document.createElement("div");
        postContainer.classList.add("post");

        // Create post content
        const postContent = `
            <div>
                <p style="text-align: right; font-size: small; font-weight: 700"><i>${post.dateOfPost}</i></p>
                <h1><i>${post.titlePost}<i></h1>
                <p style="text-align: center"><img class="post-image" src="${post.imagePost}" alt="Post Image"></p>
                <div class="description-container">
                    <p>${post.descriptionPost}</p>
                </div>
                <br>
                
                <div class="reaction-comment-container">
                    <div class="like-container" id="likeContainer_${post.postID}">
                        <span class="reaction-count">${post.numberReactions}</span>
                        <div class="like-button" id="likeButton_${post.postID}" onclick="handleLike(${post.postID})">
                            <span class="icon">❤️</span>
                        </div>
                    </div>
                    <div class="comment-container">
                        <span>${post.numberComments} Comments</span><br>
                        <button class="comment-button" data-post-id="${post.postID}">Comment</button>
                    </div>
                </div>
            </div>
        `;

        // Set post content to the post container
        postContainer.innerHTML = postContent;

        // Append the post container to the blog posts container
        blogPostsContainer.appendChild(postContainer);

        // Add click event listener to each image
        const postImages = postContainer.querySelectorAll('.post-image');
        postImages.forEach(image => {
            image.addEventListener('click', () => {
                openModal(image.src);
            });
        });

        // Add click event listener to comment button
        const commentButton = postContainer.querySelector('.comment-button');
        commentButton.addEventListener('click', () => {
            handleComment(post.postID);
        });
    }


    // Render each blog post
    fetch('get_posts.php')
        .then(response => response.json())
        .then(postsData => {
            const blogPostsContainer = document.getElementById("blog-posts");
            postsData.forEach(post => {
                renderPost(post);
                // Add a separator (hr) between posts for better visual separation
                const separator = document.createElement("hr");
                blogPostsContainer.appendChild(separator);
            });
        })
        .catch(error => console.error('Error fetching posts:', error));


    // Modal functions
    function openModal(imageSrc) {
        const modal = document.getElementById('myModal');
        const modalImg = document.getElementById('modalImage');
        const closeBtn = document.getElementById('closeBtn');

        modalImg.src = imageSrc;

        // Wait for the image to load before calculating its dimensions
        modalImg.onload = function () {
            // Calculate the position to center the image
            const topPosition = Math.max(0, (window.innerHeight - modalImg.height) / 2);
            const leftPosition = Math.max(0, (window.innerWidth - modalImg.width) / 2);

            // Set the position and display the modal
            modal.style.display = 'block';
            modal.style.top = topPosition + 'px';
            modal.style.left = leftPosition + 'px';
        };

        closeBtn.addEventListener('click', closeModal);
        window.addEventListener('click', outsideClick);
    }

    function closeModal() {
        const modal = document.getElementById('myModal');
        modal.style.display = 'none';
    }

    function outsideClick(e) {
        const modal = document.getElementById('myModal');
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    }

    function handleLike(postId) {
        const likedIndex = likedPostIds.indexOf(postId);

        if (likedIndex === -1) {
            likedPostIds.push(postId);
        } else {
            likedPostIds.splice(likedIndex, 1);
        }

        updateLikeStatus(postId);
        // Additional logic or API call to handle the like action
    }

    function updateLikeStatus(postId) {
        const likeButton = document.getElementById(`likeButton_${postId}`);
        const likeContainer = document.getElementById(`likeContainer_${postId}`);
        const isLiked = likedPostIds.includes(postId);

        if (isLiked) {
            likeButton.classList.add('active');
            likeContainer.classList.add('active');
        } else {
            likeButton.classList.remove('active');
            likeContainer.classList.remove('active');
        }
    }

    function handleComment(postId) {
        window.location.href = `indexCom.php?postId=${postId}`;
    }
});

function openEditForm(commentID, comment) {
    var editForm = document.getElementById("edit-form");
    var commentInput = editForm.querySelector("textarea[name='comment']");
    var commentIDInput = editForm.querySelector("input[name='commentID']");

    commentInput.value = comment;
    commentIDInput.value = commentID;

    // Hiển thị form chỉnh sửa
    editForm.style.display = "block";
}

