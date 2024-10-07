<?php

namespace App\Http\Controllers;

use App\DTOs\SavedCardDTO;
use App\Enums\IsActiveEnum;
use App\Http\Requests\ChangeSubscribe;
use App\Http\Requests\ChangeSubscribeRenewalRequest;
use App\Http\Requests\SubscribeRegisterRequest;
use App\Jobs\PaymentJob;
use App\Jobs\SubscribeGetPaymentJob;
use App\Services\SubscribeService;
use App\Traits\HttpResponseTrait;
use Illuminate\Http\Request;

class SubscribeController extends Controller
{
    use HttpResponseTrait;

    private $subscribePrice = 100;
    public function __construct(
        private SubscribeService $subscribeService
    ) {
        $this->subscribeService = $subscribeService;
    }

    public function addSubscribe(SubscribeRegisterRequest $request) {
        $user = $this->subscribeService->isAlreadyExistUser($request->user_id);
        if (is_null($user)) {
            return $this->error(null, 'Kullanıcı bulunamadı', 404);
        }

        $card = $this->subscribeService->getUserCardByNumber($request->card['number']);
        if ($request->card['saved']) {
            $savedCardDTO = new SavedCardDTO($request->user_id, $request->card['number'], $request->card['name'], $request->card['expire_date'], $request->card['cvv']);
            $card = $this->subscribeService->addCard($savedCardDTO);
        }

        if (is_null($card) && !$request->card['saved']) {
            return $this->error(null, 'Kard bilgisi bulunmamaktadır', 404);
        }

        $this->subscribeService->addMoneyToWallet($card->id);
        $getWallet = $this->subscribeService->getWallet($card->id);

        if ($getWallet->price > $this->subscribePrice) {
            dispatch(new PaymentJob($card, $user))
                ->onQueue('payment');

            return $this->success(null, 'Abonelik tarihi güncellendi', 200);
        }
    }

    public function changeSubscribeRenewal(ChangeSubscribeRenewalRequest $request)
    {
        $changeRenewal = $this->subscribeService->changeRenewal($request->change_renewal, $request->user_id);

        if ($changeRenewal) {
            return $this->success(null, 'Başarılı bir şekilde değişti', 200);
        }
    }

    public function changeSubscribe(ChangeSubscribe $request)
    {
        $changeSubscribe = $this->subscribeService->changeSubscribe($request->user_id);

        if ($changeSubscribe) {
            $detailName = $changeSubscribe->is_subscribe == IsActiveEnum::ACTIVE->value ? 'oluşturuldu' : 'silindi';
            return $this->success(['status' => $changeSubscribe->is_subscribe], 'Aboneliğiniz ' . $detailName);
        }
    }
}
