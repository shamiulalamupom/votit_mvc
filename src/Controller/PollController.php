<?php
namespace App\Controller;

use App\Repository\PollRepository;
use App\Repository\PollItemRepository;
use App\Repository\UserPollItemRepository;
use App\Entity\Poll;
use App\Entity\PollItem;
use App\Entity\UserPollItem;

class PollController extends Controller {
    public function list() {
        $pollRepository = new PollRepository();
        $polls = $pollRepository->findAll();
        $this->render('poll/list', ['polls' => $polls]);
    }
    public function show() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /');
            exit;
        }
        $repo = new PollRepository();
        $poll = $repo->find($id);
        $itemRepo = new PollItemRepository();
        $items = $itemRepo->findByPollId($id);
        $voteRepo = new UserPollItemRepository();
        $results = $voteRepo->countVotes($id);
        $this->render('poll/show', ['poll' => $poll, 'items' => $items, 'results' => $results]);
    }
    public function create() {
        if (empty($_SESSION['user'])) {
            header('Location: /login/');
            exit;
        }

        $this->render('poll/create');
    }

    public function createPost() {
        if (empty($_SESSION['user'])) {
            header('Location: /login/');
            exit;
        }

        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $categoryId = (int)($_POST['category_id'] ?? 0);
        $optionsRaw = trim($_POST['options'] ?? '');

        if ($title && $description && $categoryId && $optionsRaw) {
            $userId = (int)$_SESSION['user']->getId();

            $poll = new Poll(null, $title, $description, $userId, $categoryId);
            $pollRepo = new PollRepository();
            $poll = $pollRepo->create($poll);

            $lines = array_filter(array_map('trim', explode("\n", $optionsRaw)));
            $itemRepo = new PollItemRepository();
            foreach ($lines as $line) {
                $item = new PollItem(null, $line, $poll->getId());
                $itemRepo->create($item);
            }

            header('Location: /poll/?id=' . $poll->getId());
            exit;
        }

        header('Location: /poll/create/');
        exit;
    }
  
    public function vote() {
        if (empty($_SESSION['user'])) {
            header('Location: /login/');
            exit;
        }

        $pollId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $pollItemId = isset($_POST['option']) ? (int)$_POST['option'] : 0;

        if ($pollId && $pollItemId) {
            $userId = (int)$_SESSION['user']->getId();
            $voteRepo = new UserPollItemRepository();
            $voteRepo->removeVotesForUserAndPoll($userId, $pollId);
            $voteRepo->addVote(new UserPollItem($userId, $pollItemId));
        }

        header('Location: /poll/?id=' . $pollId);
        exit;
    }
}
