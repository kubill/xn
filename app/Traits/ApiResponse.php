<?php

namespace App\Traits;


use Symfony\Component\HttpFoundation\Response as FoundationResponse;

trait ApiResponse
{
    /**
     * @var int
     */
    protected $statusCode = FoundationResponse::HTTP_OK;

    /**
     * @return mixed
     */
    private function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param $statusCode
     *
     * @return $this
     */
    private function setStatusCode($statusCode)
    {

        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * @param $data
     * @param array $header
     *
     * @return mixed
     */
    private function respond($data, $header = [])
    {
        return response()->json($data, $this->getStatusCode(), $header);
    }

    /**
     * @param $status
     * @param array $data
     * @param null $code
     *
     * @return mixed
     */
    private function status($status, array $data, $code = null)
    {

        if ($code) {
            $this->setStatusCode($code);
        }

        return $this->respond($data);
    }

    /**
     * @param $message
     * @param int $code
     * @param bool $status
     *
     * @return mixed
     */
    private function failed($message, $code = FoundationResponse::HTTP_BAD_REQUEST, $status = false)
    {
        return $this->setStatusCode($code)->message($message, null, $status);
    }

    /**
     * @param string $message
     * @param array $data
     * @param bool $status
     *
     * @return mixed
     */
    private function message($message, $data = [], $status = true)
    {
        return $this->status($status, ['message' => $message, 'data' => $data]);
    }

    /**
     * @param string $message
     *
     * @return mixed
     */
    public function internalError($message = "Internal Error!")
    {
        return $this->failed($message, FoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @param $data
     * @param string $message
     *
     * @return mixed
     */
    public function created($data = [], $message = "created")
    {
        return $this->setStatusCode(FoundationResponse::HTTP_CREATED)
            ->message($message, $data);
    }

    /**
     * @param $data
     * @param string $message
     *
     * @return mixed
     */
    public function success($data, $message = 'success')
    {
        return $this->message($message, $data);
    }

    /**
     * @param $data
     * @param string $message
     *
     * @return mixed
     */
    public function error($data, $message = 'error')
    {
        return $this->setStatusCode(FoundationResponse::HTTP_BAD_REQUEST)->message($message, $data, false);
    }

    /**
     * @param string $message
     * @param int $code
     * @param bool $status
     *
     * @return mixed
     */
    public function unAuth($message = 'Unauthorized', $code = FoundationResponse::HTTP_UNAUTHORIZED, $status = false)
    {
        return $this->setStatusCode($code)->message($message, null, $status);
    }

    /**
     * @param string $message
     *
     * @return mixed
     */
    public function notFond($message = 'Not Fond!')
    {
        return $this->failed($message, Foundationresponse::HTTP_NOT_FOUND);
    }
}
