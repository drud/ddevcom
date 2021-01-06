<?php declare(strict_types = 1);
/**
 * Set return type of get_post().
 */

namespace PHPStan\WordPress;

use PhpParser\Node\Expr\FuncCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\Type\DynamicFunctionReturnTypeExtension;
use PHPStan\Type\Type;
use PHPStan\Type\ArrayType;
use PHPStan\Type\StringType;
use PHPStan\Type\IntegerType;
use PHPStan\Type\MixedType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\NullType;
use PHPStan\Type\TypeCombinator;

class GetPostDynamicFunctionReturnTypeExtension implements DynamicFunctionReturnTypeExtension
{
	public function isFunctionSupported(FunctionReflection $functionReflection): bool
	{
		return in_array($functionReflection->getName(), ['get_post', 'get_page_by_path'], true);
	}

	public function getTypeFromFunctionCall(FunctionReflection $functionReflection, FuncCall $functionCall, Scope $scope): Type
	{
		$output = 'OBJECT';
		$argsCount = count($functionCall->args);
		if ($argsCount >= 2 && $functionCall->args[1]->value !== 'OBJECT') {
    		$output = $functionCall->args[1]->value;
		}
		if ($output === 'ARRAY_A') {
			return TypeCombinator::union(new ArrayType(new StringType(), new MixedType()), new NullType());
		}
		if ($output === 'ARRAY_N') {
			return TypeCombinator::union(new ArrayType(new IntegerType(), new MixedType()), new NullType());
		}

		return TypeCombinator::union(new ObjectType('WP_Post'), new NullType());
	}
}
