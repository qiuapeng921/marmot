#!/bin/bash
if [ $1 == "dev" ]
then
	confd -confdir="conf/dev" -onetime -backend etcd -node http://etcd.etcd-ha:2379
	echo "conf dev done"
fi
if [ $1 == "dev" ]
then
	confd -confdir="conf/test" -onetime -backend etcd -node http://etcd.etcd-ha:2379
	echo "conf test done"
fi