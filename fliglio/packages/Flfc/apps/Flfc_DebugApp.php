<?php

/**
 * 
 * @package Flfc
 */
class Flfc_DebugApp extends Flfc_MiddleWare {

	public function call(Flfc_Context $context) {
		if ($context->isDebug()) {
			if (isset($context->getRequest()->getParams()->clearSession)) {
				$s = Util_Storage_Session::singleton();
				session_destroy();
				print "session destroyed";
				return;
			}
		}

		try { 
			$this->wrappedApp->call($context);
			FlMon_Logging_Log::get()->flush();
		} catch (Flfc_RedirectException $e) {
			throw $e;
		} catch (Flfc_InternalRedirectException $e) {
			throw $e;
		} catch (Flfc_PageNotFoundException $e) {
			throw $e;
		} catch (Exception $e) {
			FlMon_Logging_Log::get()->error($e->getMessage());
			FlMon_Logging_Log::get()->flush();
			throw $e;
		}
	}

}
