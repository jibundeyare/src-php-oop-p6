<?php

/**
 * @param int $id id of an article
 * @param array $articles array containing articles
 * @return bool|array the function returns false if the article is not found or the article itself if it is found
 */
function articleExists(int $id, array $articles): bool {
    foreach ($articles as $article) {
        if ($article['id'] === $id) {
            return $article;
        }
    }

    return false;
}
