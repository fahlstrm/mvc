<?php

declare(strict_types=1);

namespace Mos\Router;

use Frah\YatzyGame\Game;

use function Mos\Functions\{
    destroySession,
    redirectTo,
    renderView,
    renderTwigView,
    sendResponse,
    url
};

/**
 * Class Router.
 */
class Router
{
    public static function dispatch(string $method, string $path): void
    {
        if ($method === "GET" && $path === "/") {
            $data = [
                "header" => "21",
                "message" => "Välkommen till 21, spelet där datorn är din dealer!",
            ];
            $body = renderView("layout/page.php", $data);
            sendResponse($body);
            return;
        } else if ($method === "GET" && $path === "/session") {
            $body = renderView("layout/session.php");
            sendResponse($body);
            return;
        } else if ($method === "GET" && $path === "/session/destroy") {
            destroySession();
            redirectTo(url("/session"));
            return;
        } else if ($method === "GET" && $path === "/debug") {
            $body = renderView("layout/debug.php");
            sendResponse($body);
            return;
        } else if ($method === "GET" && $path === "/twig") {
            $data = [
                "header" => "Twig page",
                "message" => "Hey, edit this to do it youreself!",
            ];
            $body = renderTwigView("index.html", $data);
            sendResponse($body);
            return;
        } else if ($method === "GET" && $path === "/some/where") {
            $data = [
                "header" => "Rainbow page",
                "message" => "Hey, edit this to do it youreself!",
            ];
            $body = renderView("layout/page.php", $data);
            sendResponse($body);
            return;
        } else if ($method === "GET" && $path === "/dice") {
            if (!isset($_SESSION["amount"])) {
                $callable = new Game();
                $callable->startGame();
                $_SESSION["object"] = $callable;
                $_SESSION["continue"] = "play";
            } else if ($_SESSION["continue"] == "play") {
                $_SESSION["object"]->createDices(intval($_SESSION["amount"]));
                $_SESSION["object"]->data = [
                    "header" => "Kom igen då!",
                    "message" => "Tryck på fortsätt om du vill fortsätta"
                ];
                $_SESSION["continue"] = "ongoing";

                $_SESSION["object"]->playGamePlayer($_SESSION["object"]->data);
            } else if ($_SESSION["continue"] == "ongoing") {
                $_SESSION["object"]->playGamePlayer($_SESSION["object"]->data);
            } else if ($_SESSION["continue"] == "stop") {
                $_SESSION["object"]->playGameComputer($_SESSION["object"]->data);
            }
            return;
        } else if ($method === "POST" && $path === "/middle/redDiceGame") {
            $_SESSION["amount"] = $_POST["amount"] ?? null;
            $_SESSION["newGame"] = null;
            redirectTo(url("/dice"));
            return;
        } else if ($method === "POST" && $path === "/middle/continueGame") {
            $_SESSION["continue"] = array_key_first($_POST);
            redirectTo(url("/dice"));
            return;
        } else if ($method === "POST" && $path === "/middle/resetScore") {
            $_SESSION["object"]->resetScore();
            redirectTo(url("/dice"));
            return;
        }
        $data = [
            "header" => "404",
            "message" => "The page you are requesting is not here. You may also checkout the HTTP response code, it should be 404.",
        ];
        $body = renderView("layout/page.php", $data);
        sendResponse($body, 404);
    }
}
