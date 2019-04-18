<?php
namespace Contest\Contestmanage\App\Gson;


use Tebru\Gson\JsonSerializer;

class GsonLoadForm implements JsonSerializer
{
    public function serialize($object, PhpType $type, JsonSerializationContext $context): JsonElement
    {
        $jsonObject = new JsonObject();
        $jsonObject->addInteger('id', $object->getId());
        $jsonObject->addString('name', $object->getName());

        return $jsonObject;
    }


}
?>